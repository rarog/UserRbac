<?php
namespace UserRbacTest\Factory;

use UserRbac\Factory\Identity\IdentityProviderFactory;
use UserRbac\Identity\IdentityProvider;
use UserRbac\Identity\IdentityRoleProvider;
use Zend\ServiceManager\ServiceManager;

class IdentityProviderFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testFactory()
    {
        $factory = new IdentityProviderFactory;
        $serviceManager = new ServiceManager;
        $identityRoleProvider = $this->getMockBuilder(IdentityRoleProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService(IdentityRoleProvider::class, $identityRoleProvider);
        $this->assertInstanceOf(IdentityProvider::class, $factory->createService($serviceManager));
    }
}
