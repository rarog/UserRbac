<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Options\ModuleOptionsFactory;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new ModuleOptionsFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', [
            'user_rbac' => [],
        ]);

        $this->assertInstanceof(ModuleOptions::class, $factory($serviceManager, null));
    }
}
