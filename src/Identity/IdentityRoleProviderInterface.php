<?php
namespace UserRbac\Identity;

use ZfcUser\Entity\UserInterface;

interface IdentityRoleProviderInterface
{

    /**
     * Get the list of roles of a user
     *
     * @return string[]
     */
    public function getIdentityRoles(UserInterface $user = null);
}
