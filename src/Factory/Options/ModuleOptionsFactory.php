<?php
namespace UserRbac\Factory\Options;

use Interop\Container\ContainerInterface;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    /**
     * Gets ModuleOptions
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ModuleOptions
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ModuleOptions(
            $container->get('Config')['user_rbac']
        );
    }
}
