<?php
namespace UserRbac\Factory;

use Interop\Container\ContainerInterface;
use UserRbac\Identity\IdentityProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
        return new IdentityProvider($container->get('UserRbac\Identity\IdentityRoleProvider'));
    }

    /**
     * Gets identity provider
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return IdentityProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->__invoke($serviceLocator, null);
    }
}
