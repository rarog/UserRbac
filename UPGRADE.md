# Upgrade guide

## From v0.x or v1.x to v2.0

Here are the major breaking changes from UserRbac <= 1.x to UserRbac 2:

- [BC] Internal rewrite to rely on ZendServiceManager >= 3.0.0 Factory interface (`Zend\ServiceManager\Factory\FactoryInterface` instead of deprecated `Zend\ServiceManager\FactoryInterface`) with compatibility to ZendServiceManager <= 2.7 removed.
- [BC] Internal switching to TableGateway and consequent moving and renaming of files. `UserRbac\Entity\UserRoleLinker` became `UserRbac\Model\UserRoleLinker` but stayed mostly unchanged besides enhancement by implementing `Zend\Stdlib\ArraySerializableInterface`. And `UserRbac\Mapper\UserRoleLinkerMapper` became `UserRbac\Model\UserRoleLinkerTable`, which retained methods `findByUserId`, `findByUser` and `findByRoleId`, while replacing `insert` with `saveUserRoleLinker`, `delete` with `deleteUserRoleLinker` and ditching some methods that should be only set during initialization.
