Getting Start Guide
====================
This module only deals linking user with the role and rest is handled by [ZfcRbac](https://github.com/ZF-Commons/zfc-rbac).

Just for example, we will have three roles:
```php
<?php
return [
    'zfc_rbac' => [
        'role_provider' => [
            'ZfcRbac\Role\InMemoryRoleProvider' => [
                'admin' => [
                    'children'    => ['member'],
                    'permissions' => [
                        'post.delete'
                    ]
                ],
                'member' => [
                    'children'    => ['guest'],
                    'permissions' => [
                        'post.add',
                        'post.edit',
                    ]
                ],
                'guest' => [
                    'permissions' => [
                        'post.view',
                    ]
                ]
            ]
        ],
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'backend*' => ['member'],
            ]        
        ]
    ],
];

```
To add a role to the user, or edit a user`s role from you controller:
```php
<?php
namespace Application\Controller;

use UserRbac\Model\UserRoleLinker;
use UserRbac\Model\UserRoleLinkerTableInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

Class MyUserController extends AbstractActionController
{
    protected $userRoleLinkerTable;

    public function __construct(UserRoleLinkerTableInterface $userRoleLinkerTable)
    {
        $this->userRoleLinkerTable = $userRoleLinkerTable;
    }
  
    public function addAction()
    {
        // support user($user) is already added
        $userRoleLinker = new UserRoleLinker();
        $userRoleLinker->setUser($user);
        $userRoleLinker->setRoleId('member');
        $this->userRoleLinkerTable->insert($userRoleLinker);   // role is added to the user   
    }
    
    public function editAction()
    {
        // to edit the role of a user, you will have to delete the record and add a new record
        // suppose $user is an instance of ZfcUser\Entity\UserInterface
        $userRoleLinker = $this->userRoleLinkerTable->findByUser($user)->current(); // if a user has only one role
        $this->userRoleLinkerTable->delete($userRoleLinker);
        $userRoleLinker->setRoleId('admin');
        $this->userRoleLinkerTable->insert($userRoleLinker);      
    } 
}
```

Add corresponding controller factory:
```php
<?php
namespace Application\Factory\Controller;

use Application\Controller\MyUserController;
use Interop\Container\ContainerInterface;
use UserRbac\Model\UserRoleLinkerTable;
use Zend\ServiceManager\Factory\FactoryInterface;

Class MyUserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MyUserController(
            $container->get(UserRoleLinkerTable::class)
        );
    } 
}
```
