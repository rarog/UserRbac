<?php
namespace UserRbacTest\Model;

use PHPUnit\Framework\TestCase;
use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTable;
use Zend\Db\Adapter\Driver\DriverInterface;
use Zend\Db\Adapter\Platform\Sql92;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGateway;
use ZfcUser\Entity\User;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use ReflectionClass;
use RuntimeException;

class UserRoleLinkerTableTest extends TestCase
{

    private function getMethod($class, $methodName)
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

    protected function setUp()
    {
        $this->tableGateway = $this->prophesize(TableGateway::class);
        $this->tableGateway->getTable()->willReturn('user_role_linker');

        $mockDriver = $this->getMockBuilder(DriverInterface::class)->getMock();
        $mockDriver->expects($this->any())->method('formatParameterName')->will($this->returnValue('?'));
        $mockDriver->expects($this->any())
            ->method('createStatement')
            ->will($this->returnCallback(function () {
            return new \Zend\Db\Adapter\StatementContainer();
        }));
        $adapter = new \Zend\Db\Adapter\Adapter($mockDriver, new Sql92());
        $this->tableGateway->getAdapter()->willReturn($adapter);

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
        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->exchangeArray([
            'user_id' => 123,
            'role_id' => 'someRole',
        ]);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($userRoleLinker);

        $this->tableGateway->select([
            'user_id' => 123,
            'role_id' => 'someRole',
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
            'role_id' => 'someRole',
        ])->willReturn($resultSet->reveal());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find row with identifiers 123,someRole');
        $this->userRoleLinkerTable->getUserRoleLinker(123, 'someRole');
    }

    public function testSaveUserRoleLinkerExceptionThrown()
    {
        $userRoleLinker = new UserRoleLinker();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot handle user role linker with invalid user id');
        $this->userRoleLinkerTable->saveUserRoleLinker($userRoleLinker);
    }

    public function testSaveUserRoleLinkerExceptionThrown2()
    {
        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->setUserId(0);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot handle user role linker with invalid user id');
        $this->userRoleLinkerTable->saveUserRoleLinker($userRoleLinker);
    }

    public function testSaveUserRoleLinkerDataExistsNoInsert()
    {
        $userRoleLinkerData = [
            'user_id' => 123,
            'role_id' => 'someRole',
        ];

        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->exchangeArray($userRoleLinkerData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($userRoleLinker);

        $this->tableGateway->select($userRoleLinkerData)->willReturn($resultSet->reveal());
        $this->tableGateway->insert($this->anything())->shouldNotBeCalled();

        $this->userRoleLinkerTable->saveUserRoleLinker($userRoleLinker);
    }

    public function testSaveUserRoleLinkerDataInsert()
    {
        $userRoleLinkerData = [
            'user_id' => 123,
            'role_id' => 'someRole',
        ];

        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->exchangeArray($userRoleLinkerData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);

        $this->tableGateway->select($userRoleLinkerData)->willReturn($resultSet->reveal());
        $this->tableGateway->insert($userRoleLinkerData)->shouldBeCalled();

        $this->userRoleLinkerTable->saveUserRoleLinker($userRoleLinker);
    }

    public function testDeleteUserRoleLinker()
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
            new UserRoleLinker($user, 'role1'),
            new UserRoleLinker($user, 'role2'),
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

    public function testGetPreparedSelectStatementToFindByRoleId()
    {
        $getPreparedSelectStatementToFindByRoleId = $this->getMethod(UserRoleLinkerTable::class, 'getPreparedSelectStatementToFindByRoleId');

        $expectedPreparedStatement = 'SELECT "user".* FROM "user" INNER JOIN "user_role_linker" ON "user_role_linker"."user_id" = "user"."user_id" WHERE "user_role_linker"."role_id" = ? GROUP BY "user"."user_id"';
        $expectedParameterArray1 = [
            'where1' => 'role1',
        ];
        $expectedParameterArray2 = [
            'where1' => 'role2',
        ];

        $statement1 = $getPreparedSelectStatementToFindByRoleId->invokeArgs($this->userRoleLinkerTable, ['role1']);
        $this->assertEquals($expectedPreparedStatement, $statement1->getSql());
        $this->assertEquals($expectedParameterArray1, $statement1->getParameterContainer()->getNamedArray());

        $statement2 = $getPreparedSelectStatementToFindByRoleId->invokeArgs($this->userRoleLinkerTable, ['role2']);
        $this->assertEquals($expectedPreparedStatement, $statement2->getSql());
        $this->assertEquals($expectedParameterArray2, $statement2->getParameterContainer()->getNamedArray());
    }
}
