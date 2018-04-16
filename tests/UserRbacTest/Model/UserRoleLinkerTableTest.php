<?php
namespace UserRbacTest\Mapper;

use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Model\UserRoleLinker;
use Zend\Db\Sql\Select;
use ZfcUser\Entity\User;
use ReflectionClass;

class UserRoleLinkerTableTest extends \PHPUnit\Framework\TestCase
{
    public function testFindByUser()
    {
        $mapper = new UserRoleLinkerTable();
        $user = new User();
        $user->setId(13);
        $mapper->setEntityPrototype(new UserRoleLinker());
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $mapper->setDbAdapter($adapter);
        $sql = $this->getMockBuilder('Zend\Db\Sql\Sql')
            ->disableOriginalConstructor()
            ->getMock();
        $stmt = $this->createMock('Zend\Db\Adapter\Driver\StatementInterface');
        $sql->expects($this->once())
            ->method('prepareStatementForSqlObject')
            ->will($this->returnValue($stmt));

        $stmt->expects($this->once())
            ->method('execute')
            ->will(
            $this->returnValue([
                [
                    'user_id' => 13,
                    'role_id' => 'role1',
                ],
                [
                    'user_id' => 13,
                    'role_id' => 'role2',
                ]
            ]));
        $this->getMethod('setSlaveSql')->invokeArgs($mapper, [$sql]);
        $sql->expects($this->once())
            ->method('select')
            ->will($this->returnValue(new Select()));
        $resultSet =  $mapper->findByUser($user);
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
        $this->assertEquals(count($expectedResultArray), count($resultSet));
        foreach ($resultSet as $i => $result) {
            $this->assertEquals($expectedResultArray[$i]->getRoleId(), $result->getRoleId());
            $this->assertEquals($expectedResultArray[$i]->getUserId(), $result->getUserId());
        }
    }

    protected function getMethod($name)
    {
        $class = new ReflectionClass(UserRoleLinkerTable::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
