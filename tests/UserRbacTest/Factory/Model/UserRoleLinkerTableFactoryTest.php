<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Model\UserRoleLinkerTableFactory;
use UserRbac\Module\UserRoleLinkerMapper;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceManager;

class UserRoleLinkerTableFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new UserRoleLinkerTableFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(AdapterInterface::class, $adapter);

        $this->assertInstanceOf(UserRoleLinkerMapper::class, $factory($serviceManager, null));
    }
}
