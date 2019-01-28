<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock\Writer;

use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Availability\Persistence\Map\SpyAvailabilityTableMap;
use Orm\Zed\Availability\Persistence\SpyAvailabilityAbstract;
use Orm\Zed\Availability\Persistence\SpyAvailabilityAbstractQuery;
use Orm\Zed\Availability\Persistence\SpyAvailabilityQuery;
use Orm\Zed\Oms\Persistence\Map\SpyOmsProductReservationTableMap;
use Orm\Zed\Oms\Persistence\SpyOmsProductReservationQuery;
use Orm\Zed\Oms\Persistence\SpyOmsProductReservationStoreQuery;
use Orm\Zed\Stock\Persistence\Map\SpyStockProductTableMap;
use Orm\Zed\Stock\Persistence\SpyStock;
use Orm\Zed\Stock\Persistence\SpyStockProductQuery;
use Orm\Zed\Stock\Persistence\SpyStockQuery;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockHydratorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class ProductStockPropelDataSetWriter implements DataSetWriterInterface
{
    protected const KEY_AVAILABILITY_SKU = 'KEY_AVAILABILITY_SKU';
    protected const KEY_AVAILABILITY_QUANTITY = 'KEY_AVAILABILITY_QUANTITY';
    protected const KEY_AVAILABILITY_ID_STORE = 'KEY_AVAILABILITY_ID_STORE';
    protected const KEY_AVAILABILITY_IS_NEVER_OUT_OF_STOCK = 'KEY_AVAILABILITY_IS_NEVER_OUT_OF_STOCK';
    protected const KEY_AVAILABILITY_ID_AVAILABILITY_ABSTRACT = 'KEY_AVAILABILITY_ID_AVAILABILITY_ABSTRACT';

    protected const COL_AVAILABILITY_TOTAL_QUANTITY = 'availabilityTotalQuantity';
    protected const COL_STOCK_PRODUCT_TOTAL_QUANTITY = 'stockProductTotalQuantity';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface
     */
    protected $productBundleFacade;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    private $storeFacade;

    /**
     * @var \Spryker\Zed\Stock\Business\StockFacadeInterface
     */
    private $stockFacade;

    /**
     * @param \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface $productBundleFacade
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\Stock\Business\StockFacadeInterface $stockFacade
     */
    public function __construct(
        ProductBundleFacadeInterface $productBundleFacade,
        ProductRepositoryInterface $productRepository,
        StoreFacadeInterface $storeFacade,
        StockFacadeInterface $stockFacade
    ) {
        $this->productBundleFacade = $productBundleFacade;
        $this->productRepository = $productRepository;
        $this->storeFacade = $storeFacade;
        $this->stockFacade = $stockFacade;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $stockEntity = $this->createOrUpdateStock($dataSet);
        $this->createOrUpdateProductStock($dataSet, $stockEntity);
        $this->updateAvailability($dataSet);

        if ($dataSet[ProductStockHydratorStep::KEY_IS_BUNDLE]) {
            $this->productBundleFacade->updateBundleAvailability($dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
        } else {
            $this->productBundleFacade->updateAffectedBundlesAvailability($dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
            $this->productBundleFacade->updateAffectedBundlesStock($dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
        }
    }

    /**
     * @return void
     */
    public function flush(): void
    {
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\Stock\Persistence\SpyStock
     */
    protected function createOrUpdateStock(DataSetInterface $dataSet)
    {
        $stockTransfer = $dataSet[ProductStockHydratorStep::STOCK_ENTITY_TRANSFER];
        $stockEntity = SpyStockQuery::create()
            ->filterByName($stockTransfer->getName())
            ->findOneOrCreate();
        $stockEntity->fromArray($stockTransfer->modifiedToArray());
        $stockEntity->save();

        return $stockEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Orm\Zed\Stock\Persistence\SpyStock $stockEntity
     *
     * @return void
     */
    protected function createOrUpdateProductStock(DataSetInterface $dataSet, SpyStock $stockEntity): void
    {
        $stockProductEntityTransfer = $dataSet[ProductStockHydratorStep::STOCK_PRODUCT_ENTITY_TRANSFER];
        $idProductConcrete = $this->productRepository->getIdProductByConcreteSku($dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
        $stockProductEntity = SpyStockProductQuery::create()
            ->filterByFkProduct($idProductConcrete)
            ->filterByFkStock($stockEntity->getIdStock())
            ->findOneOrCreate();
        $stockProductEntity->fromArray($stockProductEntityTransfer->modifiedToArray());
        $stockProductEntity->save();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function updateAvailability(DataSetInterface $dataSet): void
    {
        $storeTransfer = $this->storeFacade->getCurrentStore();

        $this->updateAvailabilityForStore($dataSet, $storeTransfer);

        foreach ($storeTransfer->getStoresWithSharedPersistence() as $storeName) {
            $storeTransfer = $this->storeFacade->getStoreByName($storeName);
            $this->updateAvailabilityForStore($dataSet, $storeTransfer);
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    protected function updateAvailabilityForStore(DataSetInterface $dataSet, StoreTransfer $storeTransfer): void
    {
        $concreteSku = $dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU];
        $abstractSku = $this->productRepository->getAbstractSkuByConcreteSku($concreteSku);
        $idStore = $this->getIdStore($storeTransfer);

        $stockProductQuantity = $this->getStockProductQuantityForStore($concreteSku, $storeTransfer);
        $availabilityAbstractEntity = $this->getAvailabilityAbstract($abstractSku, $idStore);
        $this->persistAvailabilityData([
            static::KEY_AVAILABILITY_SKU => $concreteSku,
            static::KEY_AVAILABILITY_QUANTITY => $stockProductQuantity,
            static::KEY_AVAILABILITY_ID_AVAILABILITY_ABSTRACT => $availabilityAbstractEntity->getIdAvailabilityAbstract(),
            static::KEY_AVAILABILITY_ID_STORE => $idStore,
            static::KEY_AVAILABILITY_IS_NEVER_OUT_OF_STOCK => $dataSet[ProductStockHydratorStep::KEY_IS_NEVER_OUT_OF_STOCK],
        ]);

        $this->updateAbstractAvailabilityQuantity($availabilityAbstractEntity, $idStore);
    }

    /**
     * @param string $concreteSku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return int
     */
    protected function getStockProductQuantityForStore(string $concreteSku, StoreTransfer $storeTransfer): int
    {
        $physicalItems = $this->calculateProductStockForSkuAndStore($concreteSku, $storeTransfer);
        $reservedItems = $this->getReservationQuantityForStore($concreteSku, $storeTransfer);
        $stockProductQuantity = $physicalItems - $reservedItems;

        return $stockProductQuantity > 0 ? $stockProductQuantity : 0;
    }

    /**
     * @param string $concreteSku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return int
     */
    protected function calculateProductStockForSkuAndStore(string $concreteSku, StoreTransfer $storeTransfer): int
    {
        $idProductConcrete = $this->productRepository->getIdProductByConcreteSku($concreteSku);
        $stockNames = $this->getStoreWarehouses($storeTransfer->getName());

        return $this->getStockProductQuantityByIdProductAndStockNames($idProductConcrete, $stockNames);
    }

    /**
     * @param string $storeName
     *
     * @return array
     */
    protected function getStoreWarehouses(string $storeName): array
    {
        return $this->stockFacade->getStoreToWarehouseMapping()[$storeName] ?? [];
    }

    /**
     * @param int $idProductConcrete
     * @param string[] $stockNames
     *
     * @return int
     */
    protected function getStockProductQuantityByIdProductAndStockNames(int $idProductConcrete, array $stockNames): int
    {
        $stockProductTotalQuantity = SpyStockProductQuery::create()
            ->filterByFkProduct($idProductConcrete)
            ->useStockQuery()
                ->filterByName($stockNames, Criteria::IN)
            ->endUse()
            ->withColumn(sprintf('SUM(%s)', SpyStockProductTableMap::COL_QUANTITY), static::COL_STOCK_PRODUCT_TOTAL_QUANTITY)
            ->select([static::COL_STOCK_PRODUCT_TOTAL_QUANTITY])
            ->findOne();

        return (int)$stockProductTotalQuantity;
    }

    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return int
     */
    protected function getReservationQuantityForStore(string $sku, StoreTransfer $storeTransfer): int
    {
        $idStore = $this->getIdStore($storeTransfer);

        $reservations = SpyOmsProductReservationQuery::create()
            ->filterBySku($sku)
            ->filterByFkStore($idStore)
            ->select([
                SpyOmsProductReservationTableMap::COL_RESERVATION_QUANTITY,
            ])
            ->find()
            ->toArray();

        $reservationQuantity = 0;

        foreach ($reservations as $reservation) {
            $reservationQuantity += $reservation[SpyOmsProductReservationTableMap::COL_RESERVATION_QUANTITY];
        }

        $reservationQuantity += $this->getReservationsFromOtherStores($sku, $storeTransfer);

        return $reservationQuantity;
    }

    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStoreTransfer
     *
     * @return int
     */
    protected function getReservationsFromOtherStores(string $sku, StoreTransfer $currentStoreTransfer): int
    {
        $reservationQuantity = 0;
        $reservationStores = SpyOmsProductReservationStoreQuery::create()
            ->filterBySku($sku)
            ->find();

        foreach ($reservationStores as $omsProductReservationStoreEntity) {
            if ($omsProductReservationStoreEntity->getStore() === $currentStoreTransfer->getName()) {
                continue;
            }
            $reservationQuantity += $omsProductReservationStoreEntity->getReservationQuantity();
        }

        return $reservationQuantity;
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return int
     */
    protected function getIdStore(StoreTransfer $storeTransfer): int
    {
        if (!$storeTransfer->getIdStore()) {
            $idStore = $this->storeFacade
                ->getStoreByName($storeTransfer->getName())
                ->getIdStore();
            $storeTransfer->setIdStore($idStore);
        }

        return $storeTransfer->getIdStore();
    }

    /**
     * @param array $availabilityData
     *
     * @return void
     */
    protected function persistAvailabilityData(array $availabilityData): void
    {
        $spyAvailabilityEntity = SpyAvailabilityQuery::create()
            ->filterByFkStore($availabilityData[static::KEY_AVAILABILITY_ID_STORE])
            ->filterBySku($availabilityData[static::KEY_AVAILABILITY_SKU])
            ->findOneOrCreate();

        $spyAvailabilityEntity->setFkAvailabilityAbstract($availabilityData[static::KEY_AVAILABILITY_ID_AVAILABILITY_ABSTRACT]);
        $spyAvailabilityEntity->setQuantity($availabilityData[static::KEY_AVAILABILITY_QUANTITY]);
        $spyAvailabilityEntity->setIsNeverOutOfStock($availabilityData[static::KEY_AVAILABILITY_IS_NEVER_OUT_OF_STOCK]);

        $spyAvailabilityEntity->save();
    }

    /**
     * @param string $abstractSku
     * @param int $idStore
     *
     * @return \Orm\Zed\Availability\Persistence\SpyAvailabilityAbstract
     */
    protected function getAvailabilityAbstract(string $abstractSku, int $idStore): SpyAvailabilityAbstract
    {
        $availabilityAbstractEntity = SpyAvailabilityAbstractQuery::create()
            ->filterByAbstractSku($abstractSku)
            ->filterByFkStore($idStore)
            ->findOne();

        if ($availabilityAbstractEntity !== null) {
            return $availabilityAbstractEntity;
        }

        return $this->createAvailabilityAbstract($abstractSku, $idStore);
    }

    /**
     * @param string $abstractSku
     * @param int $idStore
     *
     * @return \Orm\Zed\Availability\Persistence\SpyAvailabilityAbstract
     */
    protected function createAvailabilityAbstract(string $abstractSku, int $idStore): SpyAvailabilityAbstract
    {
        $availableAbstractEntity = (new SpyAvailabilityAbstract())
            ->setAbstractSku($abstractSku)
            ->setFkStore($idStore);

        $availableAbstractEntity->save();

        return $availableAbstractEntity;
    }

    /**
     * @param \Orm\Zed\Availability\Persistence\SpyAvailabilityAbstract $availabilityAbstractEntity
     * @param int $idStore
     *
     * @return \Orm\Zed\Availability\Persistence\SpyAvailabilityAbstract
     */
    protected function updateAbstractAvailabilityQuantity(SpyAvailabilityAbstract $availabilityAbstractEntity, int $idStore): SpyAvailabilityAbstract
    {
        $sumQuantity = SpyAvailabilityQuery::create()
            ->filterByFkAvailabilityAbstract($availabilityAbstractEntity->getIdAvailabilityAbstract())
            ->filterByFkStore($idStore)
            ->withColumn(sprintf('SUM(%s)', SpyAvailabilityTableMap::COL_QUANTITY), static::COL_AVAILABILITY_TOTAL_QUANTITY)
            ->select([static::COL_AVAILABILITY_TOTAL_QUANTITY])
            ->findOne();

        $availabilityAbstractEntity->setFkStore($idStore);
        $availabilityAbstractEntity->setQuantity((int)$sumQuantity);
        $availabilityAbstractEntity->save();

        return $availabilityAbstractEntity;
    }
}
