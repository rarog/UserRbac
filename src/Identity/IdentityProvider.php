<?php

namespace UserRbac\Identity;

use ZfcRbac\Identity\IdentityProviderInterface;

class IdentityProvider implements IdentityProviderInterface
{
    /**
     * @var IdentityProviderInterface
     */
    protected $identityRoleProvider;

    /**
     * Constructor
     *
     * @param IdentityRoleProvider $identityRoleProvider
     */
    public function __construct(IdentityRoleProvider $identityRoleProvider)
    {
        $this->identityRoleProvider = $identityRoleProvider;
    }

    /**
     * {@inheritDoc}
     * @see \ZfcRbac\Identity\IdentityProviderInterface::getIdentity()
     */
    public function getIdentity()
    {
        return $this->identityRoleProvider;
    }
}
