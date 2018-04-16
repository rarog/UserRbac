<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Identity\IdentityRoleProviderFactory;
use UserRbac\Identity\IdentityRoleProvider;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Entity\User;

class IdentityRoleProviderFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new IdentityRoleProviderFactory();
        $serviceManager = new ServiceManager();
        $serviceManager->setService(UserRoleLinkerTable::class, $this->createMock('UserRbac\Model\UserRoleLinkerTableInterface'));
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());
        $authenticationService = $this->createMock('Zend\Authentication\AuthenticationService');
        $authenticationService->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue(false));
        $serviceManager->setService('zfcuser_auth_service', $authenticationService);
        $identityRoleProvider = $factory($serviceManager, null);
        $this->assertInstanceOf(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertEquals(null, $identityRoleProvider->getDefaultIdentity());

        $authenticationService = $this->createMock('Zend\Authentication\AuthenticationService');
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('zfcuser_auth_service', $authenticationService);
        $authenticationService->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue(true));
        $authenticationService->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($user = new User()));
        $identityRoleProvider = $factory($serviceManager, null);
        $this->assertInstanceOf(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertEquals($user, $identityRoleProvider->getDefaultIdentity());
    }
}
