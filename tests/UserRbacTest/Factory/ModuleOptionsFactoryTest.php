<?php
namespace UserRbacTest\Factory;

use UserRbac\Factory\Options\ModuleOptionsFactory;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testFactory()
    {
        $factory = new ModuleOptionsFactory;
        $serviceManager = new ServiceManager;
        $serviceManager->setService('Config', ['user_rbac' => []]);

        $this->assertInstanceof('UserRbac\Options\ModuleOptions', $factory->createService($serviceManager));
    }
}
