<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ShopApplication;

use Pyz\Yves\ExampleProductColorGroupWidget\Widget\ExampleProductColorSelectorWidget;
use Spryker\Yves\EventDispatcher\Plugin\Application\EventDispatcherApplicationPlugin;
use Spryker\Yves\Locale\Plugin\Application\LocaleApplicationPlugin;
use Spryker\Yves\Store\Plugin\Application\StoreApplicationPlugin;
use Spryker\Yves\Twig\Plugin\Application\TwigApplicationPlugin;
use SprykerShop\Yves\AgentWidget\Widget\AgentControlBarWidget;
use SprykerShop\Yves\AvailabilityNotificationWidget\Widget\AvailabilityNotificationSubscriptionWidget;
use SprykerShop\Yves\BusinessOnBehalfWidget\Widget\BusinessOnBehalfStatusWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\CartItemNoteFormWidget;
use SprykerShop\Yves\CartNoteWidget\Widget\CartNoteFormWidget;
use SprykerShop\Yves\CartToShoppingListWidget\Widget\CreateShoppingListFromCartWidget;
use SprykerShop\Yves\CategoryImageStorageWidget\Widget\CategoryImageStorageWidget;
use SprykerShop\Yves\CheckoutWidget\Widget\CheckoutBreadcrumbWidget;
use SprykerShop\Yves\CheckoutWidget\Widget\ProceedToCheckoutButtonWidget;
use SprykerShop\Yves\CompanyPage\Plugin\ShopApplication\CheckBusinessOnBehalfCompanyUserHandlerPlugin;
use SprykerShop\Yves\CompanyPage\Plugin\ShopApplication\CompanyBusinessUnitControllerRestrictionPlugin;
use SprykerShop\Yves\CompanyPage\Plugin\ShopApplication\CompanyUserRestrictionHandlerPlugin;
use SprykerShop\Yves\CompanyWidget\Widget\CompanyBusinessUnitAddressWidget;
use SprykerShop\Yves\CompanyWidget\Widget\CompanyMenuItemWidget;
use SprykerShop\Yves\CurrencyWidget\Widget\CurrencyWidget;
use SprykerShop\Yves\CustomerPage\Widget\CustomerNavigationWidget;
use SprykerShop\Yves\CustomerReorderWidget\Plugin\CustomerPage\CustomerReorderItemCheckboxWidget;
use SprykerShop\Yves\DiscountPromotionWidget\Widget\CartDiscountPromotionProductListWidget;
use SprykerShop\Yves\DiscountWidget\Widget\CheckoutVoucherFormWidget;
use SprykerShop\Yves\DiscountWidget\Widget\DiscountVoucherFormWidget;
use SprykerShop\Yves\LanguageSwitcherWidget\Widget\LanguageSwitcherWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\AddToMultiCartWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\CartOperationsWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\MiniCartWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\MultiCartListWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\MultiCartMenuItemWidget;
use SprykerShop\Yves\MultiCartWidget\Widget\QuickOrderPageWidget;
use SprykerShop\Yves\NavigationWidget\Widget\NavigationWidget;
use SprykerShop\Yves\NewsletterWidget\Widget\NewsletterSubscriptionSummaryWidget;
use SprykerShop\Yves\NewsletterWidget\Widget\NewsletterSubscriptionWidget;
use SprykerShop\Yves\PriceProductVolumeWidget\Widget\ProductPriceVolumeWidget;
use SprykerShop\Yves\PriceWidget\Widget\PriceModeSwitcherWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ProductAlternativeListWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\ShoppingListProductAlternativeWidget;
use SprykerShop\Yves\ProductAlternativeWidget\Widget\WishlistProductAlternativeWidget;
use SprykerShop\Yves\ProductBarcodeWidget\Widget\ProductBarcodeWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemCounterWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleItemsMultiCartItemsListWidget;
use SprykerShop\Yves\ProductBundleWidget\Widget\ProductBundleMultiCartItemsListWidget;
use SprykerShop\Yves\ProductCategoryWidget\Widget\ProductBreadcrumbsWithCategoriesWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedNoteWidget;
use SprykerShop\Yves\ProductDiscontinuedWidget\Widget\ProductDiscontinuedWidget;
use SprykerShop\Yves\ProductGroupWidget\Widget\ProductGroupWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductAbstractLabelWidget;
use SprykerShop\Yves\ProductLabelWidget\Widget\ProductConcreteLabelWidget;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Widget\CartProductMeasurementUnitQuantitySelectorWidget;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Widget\ManageProductMeasurementUnitWidget;
use SprykerShop\Yves\ProductOptionWidget\Widget\ProductOptionConfiguratorWidget;
use SprykerShop\Yves\ProductPackagingUnitWidget\Widget\ProductPackagingUnitWidget;
use SprykerShop\Yves\ProductRelationWidget\Widget\SimilarProductsWidget;
use SprykerShop\Yves\ProductRelationWidget\Widget\UpSellingProductsWidget;
use SprykerShop\Yves\ProductReplacementForWidget\Widget\ProductReplacementForListWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\DisplayProductAbstractReviewWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductDetailPageReviewWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductRatingFilterWidget;
use SprykerShop\Yves\ProductReviewWidget\Widget\ProductReviewDisplayWidget;
use SprykerShop\Yves\ProductSearchWidget\Widget\ProductConcreteAddWidget;
use SprykerShop\Yves\ProductSearchWidget\Widget\ProductConcreteSearchWidget;
use SprykerShop\Yves\ProductWidget\Widget\CatalogPageProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductGroupWidget;
use SprykerShop\Yves\ProductWidget\Widget\CmsProductWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductRelationWidget;
use SprykerShop\Yves\ProductWidget\Widget\PdpProductReplacementForListWidget;
use SprykerShop\Yves\ProductWidget\Widget\ProductAlternativeWidget;
use SprykerShop\Yves\QuoteApprovalWidget\Widget\QuoteApprovalStatusWidget;
use SprykerShop\Yves\QuoteApprovalWidget\Widget\QuoteApprovalWidget;
use SprykerShop\Yves\QuoteApprovalWidget\Widget\QuoteApproveRequestWidget;
use SprykerShop\Yves\QuoteRequestAgentWidget\Widget\QuoteRequestAgentCancelWidget;
use SprykerShop\Yves\QuoteRequestAgentWidget\Widget\QuoteRequestAgentOverviewWidget;
use SprykerShop\Yves\QuoteRequestWidget\Widget\QuoteRequestCancelWidget;
use SprykerShop\Yves\QuoteRequestWidget\Widget\QuoteRequestCartWidget;
use SprykerShop\Yves\QuoteRequestWidget\Widget\QuoteRequestCreateWidget;
use SprykerShop\Yves\QuoteRequestWidget\Widget\QuoteRequestMenuItemWidget;
use SprykerShop\Yves\SalesOrderThresholdWidget\Widget\SalesOrderThresholdWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\CartDeleteCompanyUsersListWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\CartListPermissionGroupWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartDetailsWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartOperationsWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartPermissionGroupWidget;
use SprykerShop\Yves\SharedCartWidget\Widget\SharedCartShareWidget;
use SprykerShop\Yves\ShopApplication\Plugin\Application\ShopApplicationApplicationPlugin;
use SprykerShop\Yves\ShopApplication\ShopApplicationDependencyProvider as SprykerShopApplicationDependencyProvider;
use SprykerShop\Yves\ShoppingListNoteWidget\Widget\ShoppingListItemNoteWidget;
use SprykerShop\Yves\ShoppingListPage\Widget\ShoppingListDismissWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\AddItemsToShoppingListWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\AddToShoppingListWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\ShoppingListMenuItemWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\ShoppingListNavigationMenuWidget;
use SprykerShop\Yves\ShoppingListWidget\Widget\ShoppingListSubtotalWidget;
use SprykerShop\Yves\TabsWidget\Widget\FullTextSearchTabsWidget;
use SprykerShop\Yves\WishlistWidget\Widget\WishlistMenuItemWidget;

class ShopApplicationDependencyProvider extends SprykerShopApplicationDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getGlobalWidgets(): array
    {
        return [
            AddToMultiCartWidget::class,
            AddToShoppingListWidget::class,
            AgentControlBarWidget::class,
            BusinessOnBehalfStatusWidget::class,
            CartDeleteCompanyUsersListWidget::class,
            CartDiscountPromotionProductListWidget::class,
            CartItemNoteFormWidget::class,
            CartListPermissionGroupWidget::class,
            CartNoteFormWidget::class,
            CartOperationsWidget::class,
            CartProductMeasurementUnitQuantitySelectorWidget::class,
            CatalogPageProductWidget::class,
            CheckoutBreadcrumbWidget::class,
            CmsProductGroupWidget::class,
            CmsProductWidget::class,
            CompanyMenuItemWidget::class,
            CreateShoppingListFromCartWidget::class,
            CurrencyWidget::class,
            CustomerNavigationWidget::class,
            CustomerReorderItemCheckboxWidget::class,
            DisplayProductAbstractReviewWidget::class,
            ExampleProductColorSelectorWidget::class,
            LanguageSwitcherWidget::class,
            ManageProductMeasurementUnitWidget::class,
            MiniCartWidget::class,
            MultiCartListWidget::class,
            MultiCartMenuItemWidget::class,
            QuoteRequestMenuItemWidget::class,
            NavigationWidget::class,
            NewsletterSubscriptionWidget::class,
            NewsletterSubscriptionSummaryWidget::class,
            PdpProductRelationWidget::class,
            PdpProductReplacementForListWidget::class,
            ProductReplacementForListWidget::class,
            PriceModeSwitcherWidget::class,
            ProductAbstractLabelWidget::class,
            ProductAlternativeListWidget::class,
            ProductAlternativeWidget::class,
            ProductBarcodeWidget::class,
            ProductBreadcrumbsWithCategoriesWidget::class,
            ProductBundleCartItemsListWidget::class,
            ProductBundleItemCounterWidget::class,
            ProductBundleItemsMultiCartItemsListWidget::class,
            ProductBundleMultiCartItemsListWidget::class,
            ProductConcreteLabelWidget::class,
            ProductDetailPageReviewWidget::class,
            ProductDiscontinuedNoteWidget::class,
            ProductDiscontinuedWidget::class,
            ProductGroupWidget::class,
            ProductOptionConfiguratorWidget::class,
            ProductPackagingUnitWidget::class,
            ProductPriceVolumeWidget::class,
            ProductRatingFilterWidget::class,
            ProductReviewDisplayWidget::class,
            QuickOrderPageWidget::class,
            SalesOrderThresholdWidget::class,
            SharedCartDetailsWidget::class,
            SharedCartOperationsWidget::class,
            SharedCartPermissionGroupWidget::class,
            SharedCartShareWidget::class,
            ShoppingListDismissWidget::class,
            ShoppingListItemNoteWidget::class,
            ShoppingListMenuItemWidget::class,
            ShoppingListNavigationMenuWidget::class,
            ShoppingListProductAlternativeWidget::class,
            ShoppingListSubtotalWidget::class,
            SimilarProductsWidget::class,
            UpSellingProductsWidget::class,
            DiscountVoucherFormWidget::class,
            CheckoutVoucherFormWidget::class,
            WishlistMenuItemWidget::class,
            WishlistProductAlternativeWidget::class,
            CompanyBusinessUnitAddressWidget::class,
            FullTextSearchTabsWidget::class,
            QuoteApprovalStatusWidget::class,
            QuoteApproveRequestWidget::class,
            ProceedToCheckoutButtonWidget::class,
            QuoteApprovalWidget::class,
            ProductConcreteSearchWidget::class,
            AddItemsToShoppingListWidget::class,
            CategoryImageStorageWidget::class,
            AvailabilityNotificationSubscriptionWidget::class,
            ProductConcreteAddWidget::class,
            QuoteRequestCreateWidget::class,
            QuoteRequestCartWidget::class,
            QuoteRequestCancelWidget::class,
            QuoteRequestAgentOverviewWidget::class,
            QuoteRequestAgentCancelWidget::class,
        ];
    }

    /**
     * @return \SprykerShop\Yves\ShopApplicationExtension\Dependency\Plugin\FilterControllerEventHandlerPluginInterface[]
     */
    protected function getFilterControllerEventSubscriberPlugins(): array
    {
        return [
            new CompanyUserRestrictionHandlerPlugin(),
            new CheckBusinessOnBehalfCompanyUserHandlerPlugin(), #BusinessOnBehalfFeature
            new CompanyBusinessUnitControllerRestrictionPlugin(),
        ];
    }

    /**
     * @return array
     */
    protected function getApplicationPlugins(): array
    {
        return [
            new TwigApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
            new ShopApplicationApplicationPlugin(),
            new StoreApplicationPlugin(),
            new LocaleApplicationPlugin(),
        ];
    }
}
