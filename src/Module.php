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
                Options\ModuleOptions::class => Factory\ModuleOptionsFactory::class,
                Mapper\UserRoleLinkerMapper::class => Factory\UserRoleLinkerMapperFactory::class,
                'UserRbac\Identity\IdentityProvider' => \UserRbac\Factory\IdentityProviderFactory::class,
                'UserRbac\Identity\IdentityRoleProvider' => \UserRbac\Factory\IdentityRoleProviderFactory::class,
                'UserRbac\View\Strategy\SmartRedirectStrategy' => \UserRbac\Factory\SmartRedirectStrategyFactory::class,
            ],
            'aliases' => [
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ]
        ];
    }
}
