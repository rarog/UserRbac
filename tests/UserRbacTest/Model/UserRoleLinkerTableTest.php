<?php
namespace UserRbacTest\Model;

use PHPUnit\Framework\TestCase;
use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTable;
use Zend\Db\TableGateway\TableGatewayInterface;
use ZfcUser\Entity\User;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use ReflectionClass;

class UserRoleLinkerTableTest extends TestCase
{
    protected function setUp()
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->userRoleLinkerTable = new UserRoleLinkerTable(
            $this->tableGateway->reveal(),
            new ZfcUserModuleOptions()
        );
    }

    public function testFindByUser()
    {
        $user = new User();
        $user->setId(13);

        $expectedResultArray = [
            new UserRoleLinker([
                'user_id' => $user->getId(),
                'role_id' => 'role1',
            ]),
            new UserRoleLinker([
                'user_id' => $user->getId(),
                'role_id' => 'role2',
            ])
        ];

        $this->tableGateway->select([
            'user_id' => 13
        ])->willReturn($expectedResultArray);

        $resultSet = $this->userRoleLinkerTable->findByUser($user);
        $this->assertEquals(count($expectedResultArray), count($resultSet));
        foreach ($resultSet as $i => $result) {
            $this->assertEquals($expectedResultArray[$i]->getUserId(), $result->getUserId());
            $this->assertEquals($expectedResultArray[$i]->getRoleId(), $result->getRoleId());
        }
    }
}
