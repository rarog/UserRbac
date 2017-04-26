<?php
namespace UserRbac\Factory;

use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Gets ModuleOptions
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return ModuleOptions
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ModuleOptions($container->get('Config')['user_rbac']);
    }

    /**
     * gets ModuleOptions
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ModuleOptions($serviceLocator->get('Config')['user_rbac']);
    }
}
