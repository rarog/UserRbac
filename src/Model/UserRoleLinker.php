<?php
namespace UserRbac\Model;

use ZfcUser\Entity\UserInterface;

/**
 * Entity of table, 'user_role_linker'
 */
class UserRoleLinker implements UserRoleLinkerInterface
{

    /**
     * User Id
     *
     * @var int $userId
     */
    protected $userId;

    /**
     * Role
     *
     * @var string $roleId
     */
    protected $roleId;

    /**
     * Constructor
     *
     * @param UserInterface|null $user
     * @param string|null $roleId
     */
    public function __construct(UserInterface $user = null, $roleId = null)
    {
        if ($user) {
            $this->setUser($user);
        }
        if ($roleId) {
            $this->setRoleId($roleId);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Model\UserRoleLinkerInterface::setUserId()
     */
    public function setUserId($userId)
    {
        $this->userId = (int) $userId;

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Model\UserRoleLinkerInterface::getUserId()
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Model\UserRoleLinkerInterface::setUser()
     */
    public function setUser(UserInterface $user)
    {
        $this->setUserId($user->getId());

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Model\UserRoleLinkerInterface::setRoleId()
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Model\UserRoleLinkerInterface::getRoleId()
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
}
