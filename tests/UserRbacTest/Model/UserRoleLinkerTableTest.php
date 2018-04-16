<?php
namespace UserRbacTest\Model;

use PHPUnit\Framework\TestCase;
use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTable;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;
use ZfcUser\Entity\User;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use RuntimeException;

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

    public function testFetchAll()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select(null)->willReturn($resultSet);

        $this->assertSame($resultSet, $this->userRoleLinkerTable->fetchAll());
    }

    public function testGetUserRoleLinker()
    {
        $userRoleLinker = new UserRoleLinker([
            'user_id' => 123,
            'role_id' => 'someRole'
        ]);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($userRoleLinker);

        $this->tableGateway->select([
            'user_id' => 123,
            'role_id' => 'someRole'
        ])->willReturn($resultSet->reveal());

        $returnedResultSet = $this->userRoleLinkerTable->getUserRoleLinker(123, 'someRole');
        $this->assertInstanceOf(UserRoleLinker::class, $returnedResultSet);
        $this->assertEquals($userRoleLinker->getArrayCopy(), $returnedResultSet->getArrayCopy());
    }

    public function testGetUserRoleLinkerExceptionThrown()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);

        $this->tableGateway->select([
            'user_id' => 123,
            'role_id' => 'someRole'
        ])->willReturn($resultSet->reveal());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find row with identifiers 123,someRole');
        $this->userRoleLinkerTable->getUserRoleLinker(123, 'someRole');
    }

    public function testDdeleteUserRoleLinker()
    {
        $this->tableGateway->delete([
            'user_id' => 123,
            'role_id' => 'someRole'
        ])->shouldBeCalled();
        $this->userRoleLinkerTable->deleteUserRoleLinker(123, 'someRole');
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
