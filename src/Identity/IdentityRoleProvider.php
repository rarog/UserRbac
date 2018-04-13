<?php
namespace UserRbac\Identity;

use UserRbac\Mapper\UserRoleLinkerMapperInterface;
use UserRbac\Options\ModuleOptionsInterface;
use ZfcRbac\Identity\IdentityInterface;
use ZfcUser\Entity\UserInterface;

/**
 * This class get roles of a identity
 */
class IdentityRoleProvider implements IdentityInterface, IdentityRoleProviderInterface
{

    /**
     *
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     *
     * @var UserRoleLinkerMapperInterface
     */
    protected $userRoleLinkerMapper;

    /**
     *
     * @var UserInterface
     */
    protected $defaultIdentity;

    /**
     * Constructor
     *
     * @param UserRoleLinkerMapperInterface $userRoleLinkerMapper,
     * @param ModuleOptionsInterface $moduleOptions
     * @return self
     */
    public function __construct(UserRoleLinkerMapperInterface $userRoleLinkerMapper, ModuleOptionsInterface $moduleOptions)
    {
        $this->userRoleLinkerMapper = $userRoleLinkerMapper;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Gets module options
     *
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Gets user role linker mapper
     *
     * @return UserRoleLinkerMapperInterface
     */
    public function getUserRoleLinkerMapper()
    {
        return $this->userRoleLinkerMapper;
    }

    /**
     * Sets identity of currently logged in user
     *
     * @param UserInterface $defaultIdentity
     * @return self
     */
    public function setDefaultIdentity(UserInterface $defaultIdentity)
    {
        $this->defaultIdentity = $defaultIdentity;

        return $this;
    }

    /**
     * Gets identity of currently logged in user
     *
     * @return UserInterface
     */
    public function getDefaultIdentity()
    {
        return $this->defaultIdentity;
    }

    /**
     * Get the list of roles of this identity(currently logged in user)
     *
     * @return string[]
     */
    public function getRoles()
    {
        return $this->getIdentityRoles();
    }

    /**
     *
     * {@inheritdoc}
     * @see \UserRbac\Identity\IdentityRoleProviderInterface::getIdentityRoles()
     */
    public function getIdentityRoles(UserInterface $user = null)
    {
        if ($user === null) {
            $user = $this->getDefaultIdentity();
            if (! $user) {
                return (array) $this->getModuleOptions()->getDefaultGuestRole();
            }
        }

        $resultSet = $this->getUserRoleLinkerMapper()->findByUser($user);

        if (count($resultSet) > 0) { // if exists in database
            $roles = [];
            foreach ($resultSet as $userRoleLinker) {
                $roles[] = $userRoleLinker->getRoleId();
            }

            return $roles;
        } else {
            return (array) $this->getModuleOptions()->getDefaultUserRole();
        }
    }
}
