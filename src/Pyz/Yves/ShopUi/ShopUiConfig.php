<?php

namespace Pyz\Yves\ShopUi;

use Pyz\Shared\ShopUi\ShopUiConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class ShopUiConfig extends AbstractBundleConfig
{
    public function getThemeName(): string
    {
        return $this->get(ShopUiConstants::YVES_THEME);
    }
}
