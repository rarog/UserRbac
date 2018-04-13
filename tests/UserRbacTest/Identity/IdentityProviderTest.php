<?php
namespace UserRbacTest\Identity;

use PHPUnit\Framework\TestCase;
use UserRbac\Identity\IdentityProvider;
use UserRbac\Identity\IdentityRoleProvider;
use UserRbac\Mapper\UserRoleLinkerMapperInterface;
use UserRbac\Options\ModuleOptions;

class IdentityProviderTest extends TestCase
{

    public function testGetIdentity()
    {
        $options = $this->createMock(ModuleOptions::class);
        $userRoleLinkerMapper = $this->createMock(UserRoleLinkerMapperInterface::class);
        $identityRoleProvider = new IdentityRoleProvider($userRoleLinkerMapper, $options);
        $identityProvider = new IdentityProvider($identityRoleProvider);
        $this->assertEquals($identityRoleProvider, $identityProvider->getIdentity());
    }
}
