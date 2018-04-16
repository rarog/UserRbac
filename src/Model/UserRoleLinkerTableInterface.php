<?php
namespace UserRbac\Model;

use ZfcUser\Entity\UserInterface;

interface UserRoleLinkerTableInterface
{

    /**
     * Finds roles of a user by his/her id
     *
     * @param int $userId
     * @return \Zend\Db\ResultSet\HydratingResultSet|array
     */
    public function findByUserId($userId);

    /**
     * Finds roles of a user
     *
     * @param UserInterface $user
     * @return \Zend\Db\ResultSet\HydratingResultSet|array
     */
    public function findByUser(UserInterface $user);
}
