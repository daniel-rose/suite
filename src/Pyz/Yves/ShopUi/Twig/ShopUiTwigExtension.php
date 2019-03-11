<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ShopUi\Twig;

use SprykerShop\Yves\ShopUi\Twig\ShopUiTwigExtension as SprykerShopUiTwigExtension;
use Spryker\Shared\Twig\TwigConstants;

class ShopUiTwigExtension extends SprykerShopUiTwigExtension
{
    /**
     * @return string
     */
    protected function getPublicFolderPath(): string
    {
        // return '/assets/' . $this->themeName . '/';
        return '/assets/default/';
    }
}
