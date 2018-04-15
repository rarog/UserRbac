<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\View\Strategy\SmartRedirectStrategyFactory;
use UserRbac\View\Strategy\SmartRedirectStrategy;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;

class SmartRedirectStrategyFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new SmartRedirectStrategyFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService('zfcuser_auth_service', new AuthenticationService());

        $this->assertInstanceOf(SmartRedirectStrategy::class, $factory($serviceManager, null));
    }
}
