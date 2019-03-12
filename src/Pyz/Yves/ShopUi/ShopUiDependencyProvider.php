<?php

namespace Pyz\Yves\ShopUi;

use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ShopUi\ShopUiDependencyProvider as SprykerShopUiDependencyProvider;

class ShopUiDependencyProvider extends SprykerShopUiDependencyProvider
{
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStore(Container $container)
    {
        $container[static::STORE] = function () {
            return Store::getInstance();
        };

        return $container;
    }
}
