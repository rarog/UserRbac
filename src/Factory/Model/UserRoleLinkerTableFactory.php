<?php
namespace UserRbac\Factory\Model;

use Interop\Container\ContainerInterface;
use UserRbac\Model\UserRoleLinkerTable;
use UserRbac\Options\ModuleOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserRoleLinkerTableFactory implements FactoryInterface
{

    /**
     * Gets user role linker
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return UserRoleLinkerTable
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $container->get(ModuleOptions::class);

        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new $options->getUserRoleLinkerEntityClass());

        $tableGateway = new TableGateway(
            $options->getTableName(),
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new UserRoleLinkerTable(
            $tableGateway,
            $container->get('zfcuser_module_options')
        );
    }
}
