<?php
namespace UserRbac\Entity;

use ZfcUser\Entity\UserInterface;

interface UserRoleLinkerInterface
{
    /**
     * Sets user`s id
     *
     * @param  int  $userId
     * @return self
     */
    public function setUserId($userId);

    /**
     * Gets user`s id
     *
     * @return int
     */
    public function getUserId();

    /**
     * Sets user
     *
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * Sets role
     *
     * @param string $roleId
     * @return self
     */
    public function setRoleId($roleId);

    /**
     * Gets role
     *
     * @return string
     */
    public function getRoleId();
}
