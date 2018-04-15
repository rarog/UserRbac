<?php
namespace UserRbacTest\Factory;

use PHPUnit\Framework\TestCase;
use UserRbac\Factory\Identity\IdentityProviderFactory;
use UserRbac\Identity\IdentityProvider;
use UserRbac\Identity\IdentityRoleProvider;
use Zend\ServiceManager\ServiceManager;

class IdentityProviderFactoryTest extends TestCase
{

    public function testFactory()
    {
        $factory = new IdentityProviderFactory();
        $serviceManager = new ServiceManager();
        $identityRoleProvider = $this->getMockBuilder(IdentityRoleProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertInstanceOf(IdentityProvider::class, $factory($serviceManager, null));
    }
}
