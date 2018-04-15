<?php
namespace UserRbac\Factory\View\Strategy;

use Interop\Container\ContainerInterface;
use UserRbac\View\Strategy\SmartRedirectStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;

class SmartRedirectStrategyFactory implements FactoryInterface
{

    /**
     * Gets SmartRedirectStrategy
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return SmartRedirectStrategy
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SmartRedirectStrategy(
            $container->get('zfcuser_auth_service')
        );
    }
}
