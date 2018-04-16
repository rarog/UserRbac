<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Model\UserRoleLinkerTableFactory;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use ReflectionClass;

class UserRoleLinkerTableFactoryTest extends TestCase
{

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

        $userRoleLinker = $factory($serviceManager, null);
        $this->assertInstanceOf(UserRoleLinkerTable::class, $userRoleLinker);

        $reflection = new ReflectionClass(UserRoleLinkerTable::class);
        $property = $reflection->getProperty('tableGateway');
        $property->setAccessible(true);

        /**
         * @var TableGatewayInterface $tableGateway
         */
        $tableGateway = $property->getValue($userRoleLinker);
        $this->assertEquals('user_role_linker', $tableGateway->getTable());
    }
}
