<?php
namespace UserRbac;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'UserRbac\ModuleOptions' => 'UserRbac\Factory\ModuleOptionsFactory',
                'UserRbac\UserRoleLinkerMapper' => 'UserRbac\Factory\UserRoleLinkerMapperFactory',
                'UserRbac\Identity\IdentityProvider' => 'UserRbac\Factory\IdentityProviderFactory',
                'UserRbac\Identity\IdentityRoleProvider' => 'UserRbac\Factory\IdentityRoleProviderFactory',
                'UserRbac\View\Strategy\SmartRedirectStrategy' => 'UserRbac\Factory\SmartRedirectStrategyFactory',
            ],
            'aliases' => [
                'UserRbac\DbAdapter' => 'Zend\Db\Adapter\Adapter',
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ]
        ];
    }
}
