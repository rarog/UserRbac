<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Model\UserRoleLinkerTableFactory;
use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use ReflectionClass;

class UserRoleLinkerTableFactoryTest extends TestCase
{

    private function getProperty($class, $propertyName)
    {
        $reflection = new ReflectionClass($class);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }

    public function testFactory()
    {
        $factory = new UserRoleLinkerTableFactory();

        $moduleOptions = new ModuleOptions();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('zfcuser_module_options', new ZfcUserModuleOptions());
        $serviceManager->setService(ModuleOptions::class, $moduleOptions);
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(AdapterInterface::class, $adapter);

        $userRoleLinkerTable = $factory($serviceManager, null);
        $this->assertInstanceOf(UserRoleLinkerTable::class, $userRoleLinkerTable);

        $property = $this->getProperty(UserRoleLinkerTable::class, 'tableGateway');

        /**
         * @var TableGateway $tableGateway
         */
        $tableGateway = $property->getValue($userRoleLinkerTable);
        $this->assertInstanceOf(TableGateway::class, $tableGateway);
        $this->assertEquals('user_role_linker', $tableGateway->getTable());
        $this->assertInstanceOf(UserRoleLinker::class, $tableGateway->getResultSetPrototype()
            ->getArrayObjectPrototype());
    }
}
