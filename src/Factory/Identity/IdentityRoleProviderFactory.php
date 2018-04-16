<?php
namespace UserRbac\Factory\Identity;

use Interop\Container\ContainerInterface;
use UserRbac\Identity\IdentityRoleProvider;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\Factory\FactoryInterface;

class IdentityRoleProviderFactory implements FactoryInterface
{

    /**
     * Gets identity role provider
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return IdentityRoleProvider
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $identityRoleProvider = new IdentityRoleProvider(
            $container->get(UserRoleLinkerTable::class),
            $container->get(ModuleOptions::class)
        );
        if ($container->get('zfcuser_auth_service')->hasIdentity()) {
            $identityRoleProvider->setDefaultIdentity(
                $container->get('zfcuser_auth_service')->getIdentity()
            );
        }

        return $identityRoleProvider;
    }
}
