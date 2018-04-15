<?php
namespace UserRbacTest\Entity;

use PHPUnit\Framework\TestCase;
use UserRbac\Model\UserRoleLinker;
use ZfcUser\Entity\User;

class UserRoleLinkerTest extends TestCase
{
    public function testSetterAndGetters()
    {
        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->setUserId(178);
        $userRoleLinker->setRoleId('manager');
        $this->assertEquals(178, $userRoleLinker->getUserId());
        $this->assertEquals('manager', $userRoleLinker->getRoleId());
        $user = new User();
        $user->setId(155);
        $userRoleLinker->setUser($user);
        $this->assertEquals(155, $userRoleLinker->getUserId());
    }
}
