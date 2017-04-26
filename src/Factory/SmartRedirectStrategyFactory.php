<?php

namespace UserRbac\Factory;

use UserRbac\View\Strategy\SmartRedirectStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SmartRedirectStrategyFactory implements FactoryInterface
{
    /**
     * Gets SmartRedirectStrategy
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return SmartRedirectStrategy
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SmartRedirectStrategy($container->get('zfcuser_auth_service'));
    }

    /**
     * Gets SmartRedirectStrategy
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return SmartRedirectStrategy
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SmartRedirectStrategy($serviceLocator->get('zfcuser_auth_service'));
    }
}
