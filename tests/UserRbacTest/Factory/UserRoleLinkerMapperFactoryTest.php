<?php
namespace UserRbacTest\Factory;

use UserRbac\Factory\UserRoleLinkerMapperFactory;
use UserRbac\Mapper\UserRoleLinkerMapper;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\ServiceManager\ServiceManager;

class UserRoleLinkerMapperFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testFactory()
    {
        $factory = new UserRoleLinkerMapperFactory;
        $serviceManager = new ServiceManager;
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions);
        $adapter = $this->getMockBuilder(DbAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(DbAdapter::class, $adapter);

        $this->assertInstanceOf(UserRoleLinkerMapper::class, $factory->createService($serviceManager));
    }
}
