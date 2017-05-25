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
                'UserRbac\ModuleOptions' => \UserRbac\Factory\ModuleOptionsFactory::class,
                'UserRbac\UserRoleLinkerMapper' => \UserRbac\Factory\UserRoleLinkerMapperFactory::class,
                'UserRbac\Identity\IdentityProvider' => \UserRbac\Factory\IdentityProviderFactory::class,
                'UserRbac\Identity\IdentityRoleProvider' => \UserRbac\Factory\IdentityRoleProviderFactory::class,
                'UserRbac\View\Strategy\SmartRedirectStrategy' => \UserRbac\Factory\SmartRedirectStrategyFactory::class,
            ],
            'aliases' => [
                'UserRbac\DbAdapter' => \Zend\Db\Adapter\Adapter::class,
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ]
        ];
    }
}
