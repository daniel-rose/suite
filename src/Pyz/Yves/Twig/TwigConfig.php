<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\Twig;

use Pyz\Shared\Twig\TwigConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Yves\Twig\TwigConfig as SprykerTwigConfig;

class TwigConfig extends SprykerTwigConfig
{
    /**
     * @param array $paths
     *
     * @return array
     */
    protected function addProjectTemplatePaths(array $paths)
    {
        $namespaces = $this->get(KernelConstants::PROJECT_NAMESPACES);
        $storeName = $this->getStoreName();
        $currentThemeNamesFallbackChain = $this->getCurrentThemeNamesFallbackChain();

        foreach ($namespaces as $namespace) {
            foreach ($currentThemeNamesFallbackChain as $themeName) {
                $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Yves/%s' . $storeName . '/Theme/' . $themeName;
            }

            $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Yves/%s' . $storeName . '/Theme/default';

            // ---

            foreach ($currentThemeNamesFallbackChain as $themeName) {
                $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Yves/%s/Theme/' . $themeName;
            }

            $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Yves/%s/Theme/default';

            // ---

            foreach ($currentThemeNamesFallbackChain as $themeName) {
                $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Shared/%s' . $storeName . '/Theme/' . $themeName;
            }

            $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Shared/%s' . $storeName . '/Theme/default';

            // ---

            foreach ($currentThemeNamesFallbackChain as $themeName) {
                $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Shared/%s/Theme/' . $themeName;
            }

            $paths[] = APPLICATION_SOURCE_DIR . '/' . $namespace . '/Shared/%s/Theme/default';
        }

        return $paths;
    }

    /**
     * @param array $paths
     *
     * @return array
     */
    protected function addCoreTemplatePaths(array $paths)
    {
        $namespaces = $this->get(KernelConstants::CORE_NAMESPACES);
        $themeName = $this->getThemeName();

        foreach ($namespaces as $namespace) {
            $paths[] = APPLICATION_VENDOR_DIR . '/*/*/src/' . $namespace . '/Yves/%s/Theme/' . $themeName;
            $paths[] = APPLICATION_VENDOR_DIR . '/*/*/src/' . $namespace . '/Yves/%s/Theme/default';
            $paths[] = APPLICATION_VENDOR_DIR . '/*/*/src/' . $namespace . '/Shared/%s/Theme/' . $themeName;
            $paths[] = APPLICATION_VENDOR_DIR . '/*/*/src/' . $namespace . '/Shared/%s/Theme/default';
        }

        $paths[] = APPLICATION_VENDOR_DIR . '/spryker/*/src/Spryker/Yves/%s/Theme/' . $themeName;
        $paths[] = APPLICATION_VENDOR_DIR . '/spryker/*/src/Spryker/Yves/%s/Theme/default';
        $paths[] = APPLICATION_VENDOR_DIR . '/spryker/*/src/Spryker/Shared/%s/Theme/' . $themeName;
        $paths[] = APPLICATION_VENDOR_DIR . '/spryker/*/src/Spryker/Shared/%s/Theme/default';

        return $paths;
    }

    protected function getFullThemeNamesFallbackChain(): array
    {
        return $this->get(TwigConstants::YVES_THEME_CHAIN);
    }

    protected function getCurrentThemeNamesFallbackChain(): array
    {
        $fullChain = $this->getFullThemeNamesFallbackChain();
        $currentThemeName = $this->getThemeName();
        $currentThemeNameKey = array_search($currentThemeName, $fullChain);
        $currentChain = array_slice($fullChain, $currentThemeNameKey);

        return $currentChain;
    }
}
