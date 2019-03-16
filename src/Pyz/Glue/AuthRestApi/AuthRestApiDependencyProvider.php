<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\AuthRestApi;

use Spryker\Glue\AuthRestApi\AuthRestApiDependencyProvider as SprykerAuthRestApiDependencyProvider;
use Spryker\Glue\OauthCompanyUser\Plugin\AuthRestApi\CompanyUserRestUserExpanderPlugin;

/**
 * @method \Spryker\Glue\AuthRestApi\AuthRestApiConfig getConfig()
 */
class AuthRestApiDependencyProvider extends SprykerAuthRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\AuthRestApiExtension\Dependency\Plugin\RestUserExpanderPluginInterface[]
     */
    protected function getRestUserExpanderPlugins(): array
    {
        return [
            new CompanyUserRestUserExpanderPlugin(),
        ];
    }
}
