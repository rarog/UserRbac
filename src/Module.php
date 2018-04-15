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
                Options\ModuleOptions::class => Factory\Options\ModuleOptionsFactory::class,
                Mapper\UserRoleLinkerMapper::class => Factory\Mapper\UserRoleLinkerMapperFactory::class,
                Model\UserRoleLinkerTableGateway::class => Factory\Model\UserRoleLinkerTableGatewayFactory::class,
                Identity\IdentityProvider::class => Factory\Identity\IdentityProviderFactory::class,
                Identity\IdentityRoleProvider::class => Factory\Identity\IdentityRoleProviderFactory::class,
                View\Strategy\SmartRedirectStrategy::class => Factory\View\Strategy\SmartRedirectStrategyFactory::class,
            ],
            'aliases' => [
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ]
        ];
    }
}
