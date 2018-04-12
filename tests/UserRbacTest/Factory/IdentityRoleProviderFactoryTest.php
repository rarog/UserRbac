<?php
namespace UserRbacTest\Factory;

use UserRbac\Factory\IdentityRoleProviderFactory;
use UserRbac\Identity\IdentityRoleProvider;
use UserRbac\Mapper\UserRoleLinkerMapper;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Entity\User;

class IdentityRoleProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $factory = new IdentityRoleProviderFactory;
        $serviceManager = new ServiceManager;
        $serviceManager->setService(UserRoleLinkerMapper::class, $this->getMock('UserRbac\Mapper\UserRoleLinkerMapperInterface'));
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions);
        $authenticationService = $this->getMock('Zend\Authentication\AuthenticationService');
        $authenticationService->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue(false));
        $serviceManager->setService('zfcuser_auth_service', $authenticationService);
        $identityRoleProvider = $factory($serviceManager, null);
        $this->assertInstanceOf(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertEquals(null, $identityRoleProvider->getDefaultIdentity());
        
        $authenticationService = $this->getMock('Zend\Authentication\AuthenticationService');
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('zfcuser_auth_service', $authenticationService);
        $authenticationService->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue(true));
        $authenticationService->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($user = new User));
        $identityRoleProvider = $factory($serviceManager, null);
        $this->assertInstanceOf(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertEquals($user, $identityRoleProvider->getDefaultIdentity());
    }
}
