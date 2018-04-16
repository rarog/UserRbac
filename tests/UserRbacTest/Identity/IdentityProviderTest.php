<?php
namespace UserRbacTest\Identity;

use PHPUnit\Framework\TestCase;
use UserRbac\Identity\IdentityProvider;
use UserRbac\Identity\IdentityRoleProvider;
use UserRbac\Model\UserRoleLinkerTableInterface;
use UserRbac\Options\ModuleOptions;

class IdentityProviderTest extends TestCase
{

    public function testGetIdentity()
    {
        $options = $this->createMock(ModuleOptions::class);
        $userRoleLinkerTable = $this->createMock(UserRoleLinkerTableInterface::class);
        $identityRoleProvider = new IdentityRoleProvider($userRoleLinkerTable, $options);
        $identityProvider = new IdentityProvider($identityRoleProvider);
        $this->assertEquals($identityRoleProvider, $identityProvider->getIdentity());
    }
}
