<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Model\UserRoleLinkerTableFactory;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceManager;

class UserRoleLinkerTableFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new UserRoleLinkerTableFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService('zfcuser_module_options', new ZfcUserModuleOptions());
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(AdapterInterface::class, $adapter);

        $this->assertInstanceOf(UserRoleLinkerTable::class, $factory($serviceManager, null));
    }
}
