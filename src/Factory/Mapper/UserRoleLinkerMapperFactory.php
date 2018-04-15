<?php
namespace UserRbac\Factory\Mapper;

use Interop\Container\ContainerInterface;
use UserRbac\Mapper\UserRoleLinkerMapper;
use UserRbac\Options\ModuleOptions;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserRoleLinkerMapperFactory implements FactoryInterface
{

    /**
     * Gets user role linker
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return UserRoleLinkerMapper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $mapper = new UserRoleLinkerMapper();
        $options = $container->get(ModuleOptions::class);
        $class = $options->getUserRoleLinkerEntityClass();
        $mapper->setEntityPrototype(new $class());
        $mapper->setDbAdapter($container->get(DbAdapter::class));
        $mapper->setTableName($options->getTableName());

        return $mapper;
    }
}
