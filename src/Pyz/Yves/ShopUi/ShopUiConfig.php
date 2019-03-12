<?php

namespace Pyz\Yves\ShopUi;

use Pyz\Shared\ShopUi\ShopUiConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class ShopUiConfig extends AbstractBundleConfig
{
    public const DEFAULT_THEME_NAME = 'default';

    public function getThemeName(): string
    {
        return $this->get(ShopUiConstants::YVES_THEME);
    }

    public function isDefaultTheme(): bool
    {
        if (static::DEFAULT_THEME_NAME === $this->getThemeName()) {
            return true;
        }

        return false;
    }
}
