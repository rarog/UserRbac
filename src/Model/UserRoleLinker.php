<?php
namespace UserRbac\Model;

use Zend\Stdlib\ArraySerializableInterface;
use ZfcUser\Entity\UserInterface;

/**
 * Entity of table, 'user_role_linker'
 */
class UserRoleLinker implements ArraySerializableInterface, UserRoleLinkerInterface
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
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->exchangeArray($data);
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

    /**
     * {@inheritDoc}
     * @see \Zend\Stdlib\ArraySerializableInterface::exchangeArray()
     */
    public function exchangeArray(array $array)
    {
        $this->setUserId(!empty($array['user_id']) ? $array['user_id'] : null);
        $this->setRoleId(!empty($array['role_id']) ? $array['role_id'] : null);
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Stdlib\ArraySerializableInterface::getArrayCopy()
     */
    public function getArrayCopy()
    {
        return [
            'user_id' => $this->getUserId(),
            'role_id' => $this->getRoleId(),
        ];
    }

}
