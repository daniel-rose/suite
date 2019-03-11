<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ShopUi;

use SprykerShop\Yves\ShopUi\ShopUiFactory as SprykerShopUiFactory;
use Pyz\Yves\ShopUi\Twig\ShopUiTwigExtension;

class ShopUiFactory extends SprykerShopUiFactory
{
    /**
     * @return \Spryker\Shared\Twig\TwigExtension
     */
    public function createShopUiTwigExtension()
    {
        return new ShopUiTwigExtension();
    }
}
