<?php
namespace UserRbacTest\Model;

use PHPUnit\Framework\TestCase;
use UserRbac\Model\UserRoleLinker;
use ZfcUser\Entity\User;

class UserRoleLinkerTest extends TestCase
{

    public function testConstructor()
    {
        $user = new User();
        $user->setId(155);

        $userRoleLinker = new UserRoleLinker(
            $user,
            'manager'
        );

        $this->assertEquals(155, $userRoleLinker->getUserId());
        $this->assertEquals('manager', $userRoleLinker->getRoleId());
    }

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

    public function testArraySerializableImplementations()
    {
        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->setUserId(178);
        $userRoleLinker->setRoleId('manager');

        $this->assertEquals([
            'user_id' => 178,
            'role_id' => 'manager',
        ], $userRoleLinker->getArrayCopy());

        $userRoleLinker->exchangeArray([
            'user_id' => 42,
            'role_id' => 'vogon',
        ]);
        $this->assertEquals(42, $userRoleLinker->getUserId());
        $this->assertEquals('vogon', $userRoleLinker->getRoleId());
    }
}
