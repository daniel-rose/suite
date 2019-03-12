<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ShopUi\Twig;

use Spryker\Shared\Kernel\Store;
use SprykerShop\Yves\ShopUi\Twig\ShopUiTwigExtension as SprykerShopUiTwigExtension;

class ShopUiTwigExtension extends SprykerShopUiTwigExtension
{
    /**
     * @var Store
     */
    protected $store;

    /**
     * @var string
     */
    protected $themeName;

    /**
     * @var bool
     */
    protected $isDefaultTheme;

    public function __construct(Store $store, string $themeName, bool $isDefaultTheme)
    {
        $this->store = $store;
        $this->themeName = $themeName;
        $this->isDefaultTheme = $isDefaultTheme;
    }

    /**
     * @return string
     */
    protected function getPublicFolderPath(): string
    {
        if ($this->isDefaultTheme) {
            return '/assets/' . $this->themeName . '/';
        }

        return '/assets/' . $this->store->getStoreName() .  '/' . $this->themeName . '/';
    }
}
