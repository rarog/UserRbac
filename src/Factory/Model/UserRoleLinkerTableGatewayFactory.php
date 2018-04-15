<?php
namespace UserRbac\Factory\Model;

use Interop\Container\ContainerInterface;
use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserRoleLinkerTableGatewayFactory implements FactoryInterface
{

    /**
     * Gets ModuleOptions
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return UserRoleLinkerTableGateway
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new UserRoleLinker());

        return new UserRoleLinkerTableGateway(
            'user_languages',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
    }
}
