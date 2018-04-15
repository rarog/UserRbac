<?php
namespace UserRbac\Factory\Identity;

use Interop\Container\ContainerInterface;
use UserRbac\Identity\IdentityProvider;
use UserRbac\Identity\IdentityRoleProvider;
use Zend\ServiceManager\Factory\FactoryInterface;

class IdentityProviderFactory implements FactoryInterface
{
    /**
     * Gets identity provider
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return IdentityProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IdentityProvider($container->get(IdentityRoleProvider::class));
    }
}
