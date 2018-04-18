<?php
namespace UserRbacTest\Model;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use UserRbac\View\Strategy\SmartRedirectStrategy;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use ZfcRbac\View\Strategy\RedirectStrategy;
use ZfcRbac\View\Strategy\UnauthorizedStrategy;
use ReflectionClass;

class SmartRedirectStrategyTest extends TestCase
{

    private function getProperty($class, $propertyName)
    {
        $reflection = new ReflectionClass($class);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }

    protected function setUp()
    {
        $log = [
            'UnauthorizedStrategyCalled' => false,
            'RedirectStrategyCalled' => false,
        ];
        $this->log = &$log;

        $this->authenticationService = $this->prophesize(AuthenticationService::class);

        $this->smartRedirectStrategy = new SmartRedirectStrategy($this->authenticationService->reveal());

        $this->unauthorizedStrategy = $this->prophesize(UnauthorizedStrategy::class);
        $this->unauthorizedStrategy->onError(Argument::any())->will(function ($args) use (&$log) {
            $log['UnauthorizedStrategyCalled'] = true;
        });

        $this->redirectStrategy = $this->prophesize(RedirectStrategy::class);
        $this->redirectStrategy->onError(Argument::any())->will(function ($args) use (&$log) {
            $log['RedirectStrategyCalled'] = true;
        });

        $serviceManager = new ServiceManager();
        $serviceManager->setService('ZfcRbac\View\Strategy\UnauthorizedStrategy', $this->unauthorizedStrategy->reveal());
        $serviceManager->setService('ZfcRbac\View\Strategy\RedirectStrategy', $this->redirectStrategy->reveal());

        $application = $this->prophesize(Application::class);
        $application->getServiceManager()->willReturn($serviceManager);

        $this->event = new MvcEvent();
        $this->event->setApplication($application->reveal());
    }

    public function testConstructor()
    {
        $property = $this->getProperty(SmartRedirectStrategy::class, 'authenticationService');

        $authenticationService = $property->getValue($this->smartRedirectStrategy);

        $this->assertInstanceOf(AuthenticationService::class, $authenticationService);
    }

    public function testOnErrorCallsRedirectStrategy()
    {
        $expectedLog = [
            'UnauthorizedStrategyCalled' => false,
            'RedirectStrategyCalled' => true,
        ];

        $this->authenticationService->hasIdentity()->willReturn(false);

        $this->smartRedirectStrategy->onError($this->event);

        $this->assertEquals($expectedLog, $this->log);
    }

    public function testOnErrorCallsUnauthorizedStrategy()
    {
        $expectedLog = [
            'UnauthorizedStrategyCalled' => true,
            'RedirectStrategyCalled' => false,
        ];

        $this->authenticationService->hasIdentity()->willReturn(true);

        $this->smartRedirectStrategy->onError($this->event);

        $this->assertEquals($expectedLog, $this->log);
    }
}
