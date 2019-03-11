<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ShopUi\Twig;

use SprykerShop\Yves\ShopUi\Twig\ShopUiTwigExtension as SprykerShopUiTwigExtension;
use Spryker\Shared\Twig\TwigConstants;

/**
 * @method \Spryker\Zed\Twig\TwigConfig getConfig()
 */
class ShopUiTwigExtension extends SprykerShopUiTwigExtension
{
    /**
     * @return string
     */
    protected function getPublicFolderPath(): string
    {
        return '/assets/custom-de/'; // $this->getConfig()->getThemeName()
    }
}
