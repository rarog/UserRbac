<?php

namespace UserRbac\Factory;

use Interop\Container\ContainerInterface;
use UserRbac\Identity\IdentityRoleProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdentityRoleProviderFactory implements FactoryInterface
{
    /**
     * Gets identity role provider
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return IdentityRoleProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $identityRoleProvider = new IdentityRoleProvider(
                $container->get('UserRbac\UserRoleLinkerMapper'),
                $container->get('UserRbac\ModuleOptions')
                );
        if ($container->get('zfcuser_auth_service')->hasIdentity()) {
            $identityRoleProvider->setDefaultIdentity(
                    $container->get('zfcuser_auth_service')->getIdentity()
                    );
        }

        return $identityRoleProvider;
    }

    /**
     * Gets identity role provider
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return IdentityRoleProvider
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->__invoke($serviceLocator, null);
    }
}
