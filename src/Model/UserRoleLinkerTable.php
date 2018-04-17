<?php

namespace UserRbac\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserOptions;
use RuntimeException;

class UserRoleLinkerTable implements UserRoleLinkerTableInterface
{
    /**
     * Table gateway
     *
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * @var ZfcUserOptions
     */
    protected $zfcUserOptions;

    /**
     * Constructor
     *
     * @param TableGatewayInterface $tableGateway
     * @param ZfcUserOptions $zfcUserOptions
     */
    public function __construct(TableGatewayInterface $tableGateway, $zfcUserOptions)
    {
        $this->tableGateway = $tableGateway;
        $this->zfcUserOptions = $zfcUserOptions;
    }

    /**
     * Gets all entries
     *
     * @param \Zend\Db\Sql\Where|\Closure|string|array $where
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll($where = null)
    {
        return $this->tableGateway->select($where);
    }

    /**
     * Get entry
     *
     * @param int $userId
     * @param string $roleId
     * @throws RuntimeException
     * @return UserRoleLinker
     */
    public function getUserRoleLinker($userId, $roleId)
    {
        $userId = (int) $userId;
        $roleId = (string) $roleId;

        $rowset = $this->fetchAll([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifiers %d,%s', $userId, $roleId));
        }

        return $row;
    }

    /**
     * User role linker save function
     * @param UserRoleLinkerInterface $userRoleLinker
     * @throws RuntimeException
     */
    public function saveUserRoleLinker(UserRoleLinkerInterface $userRoleLinker)
    {
        $userId = (int) $userRoleLinker->getUserId();

        if ($userId === 0) {
            throw new RuntimeException('Cannot handle user role linker with invalid user id');
        }

        $data = [
            'user_id' => $userId,
            'role_id' => $userRoleLinker->getRoleId(),
        ];

        try {
            if ($this->getUserRoleLinker($userId, $userRoleLinker->getRoleId())) {
                return;
            }
        } catch (RuntimeException $e) {
            $this->tableGateway->insert($data);
        }
    }

    /**
     * User language delete function
     *
     * @param int $userId
     * @param string $locale
     */
    public function deleteUserRoleLinker($userId, $roleId)
    {
        $userId = (int) $userId;
        $roleId = (string) $roleId;

        $this->tableGateway->delete([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }

    /**
     * {@inheritDoc}
     * @see \UserRbac\Model\UserRoleLinkerTableInterface::findByUserId()
     */
    public function findByUserId($userId)
    {
        $userId = (int) $userId;

        return $this->fetchAll(['user_id' => $userId]);
    }

    /**
     * {@inheritDoc}
     * @see \UserRbac\Model\UserRoleLinkerTableInterface::findByUser()
     */
    public function findByUser(UserInterface $user)
    {
        return $this->findByUserId($user->getId());
    }

    /**
     * Finds users with a specific role
     *
     * @param  string $roleId
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function findByRoleId($roleId)
    {
        $roleId = (string) $roleId;

        $select = $this->getSelect($this->zfcUserOptions->getTableName());
        $select->where(array($this->tableGateway->getTable() . '.role_id' => $roleId));
        $select->join(
            $this->tableGateway->getTable(),
            $this->tableGateway->getTable(). '.user_id = ' . $this->zfcUserOptions->getTableName(). '.user_id',
            array(),
            Select::JOIN_INNER
        );
        $select->group($this->userTableName. '.user_id');

        $entityPrototype = $this->zfcUserOptions()->getUserEntityClass();

        return $this->select($select, new $entityPrototype, $this->getZfcUserHydrator());
    }
}
