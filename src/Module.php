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
                Identity\IdentityProvider::class => Factory\IdentityProviderFactory::class,
                Identity\IdentityRoleProvider::class => Factory\IdentityRoleProviderFactory::class,
                View\Strategy\SmartRedirectStrategy::class => Factory\SmartRedirectStrategyFactory::class,
            ],
            'aliases' => [
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ]
        ];
    }
}
