<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Model\UserRoleLinkerTableGatewayFactory;
use UserRbac\Model\UserRoleLinkerTableGateway;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\AdapterInterface as DbAdapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

class UserRoleLinkerTableGatewayFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new UserRoleLinkerTableGatewayFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());
        $adapter = $this->getMockBuilder(DbAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(DbAdapter::class, $adapter);

        $userRoleLinkerTableGateway = $factory($serviceManager, null);
        $this->assertInstanceOf(UserRoleLinkerTableGateway::class, $userRoleLinkerTableGateway);
        $this->assertInstanceOf(TableGateway::class, $userRoleLinkerTableGateway);
    }
}
