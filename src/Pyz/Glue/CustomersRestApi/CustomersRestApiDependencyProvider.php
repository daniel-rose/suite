<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomersRestApi;

use Spryker\Glue\CartsRestApi\Plugin\CustomerPostRegister\UpdateCartCustomerReferencePlugin;
use Spryker\Glue\CompanyBusinessUnitsRestApi\Plugin\CustomersRestApi\CompanyBusinessUnitCustomerExpanderPlugin;
use Spryker\Glue\CompanyUsersRestApi\Plugin\CustomersRestApi\CompanyUserCustomerExpanderPlugin;
use Spryker\Glue\CustomersRestApi\CustomersRestApiDependencyProvider as SprykerCustomersRestApiDependencyProvider;

class CustomersRestApiDependencyProvider extends SprykerCustomersRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\CustomersRestApiExtension\Dependency\Plugin\CustomerPostRegisterPluginInterface[]
     */
    protected function getCustomerPostRegisterPlugins(): array
    {
        return array_merge(parent::getCustomerPostRegisterPlugins(), [
            new UpdateCartCustomerReferencePlugin(),
        ]);
    }

    /**
     * @return \Spryker\Glue\CustomersRestApiExtension\Dependency\Plugin\CustomerExpanderPluginInterface[]
     */
    protected function getCustomerExpanderPlugins(): array
    {
        return array_merge(parent::getCustomerExpanderPlugins(), [
            new CompanyUserCustomerExpanderPlugin(),
            new CompanyBusinessUnitCustomerExpanderPlugin(),
        ]);
    }
}
