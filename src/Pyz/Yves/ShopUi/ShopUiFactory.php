<?php

namespace Pyz\Yves\ShopUi;

use Pyz\Yves\ShopUi\ShopUiDependencyProvider;
use Pyz\Yves\ShopUi\Twig\ShopUiTwigExtension;
use SprykerShop\Yves\ShopUi\ShopUiFactory as SprykerShopUiFactory;

/**
 * @method \Pyz\Yves\ShopUi\ShopUiConfig getConfig()
 */
class ShopUiFactory extends SprykerShopUiFactory
{
    /**
     * @return \Spryker\Shared\Twig\TwigExtension
     */
    public function createShopUiTwigExtension()
    {
        return new ShopUiTwigExtension(
            $this->getProvidedDependency(ShopUiDependencyProvider::STORE),
            $this->getConfig()->getThemeName(),
            $this->getConfig()->isDefaultTheme()
        );
    }
}
