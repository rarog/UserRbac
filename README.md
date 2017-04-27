UserRbac
========
[![Master Branch Build Status](https://api.travis-ci.org/rarog/UserRbac.png)](http://travis-ci.org/rarog/UserRbac)
[![Latest Stable Version](https://poser.pugx.org/rarog/user-rbac/v/stable.png)](https://packagist.org/packages/rarog/user-rbac)
[![Latest Unstable Version](https://poser.pugx.org/rarog/user-rbac/v/unstable.png)](https://packagist.org/packages/rarog/user-rbac)
[![Total Downloads](https://poser.pugx.org/rarog/user-rbac/downloads.png)](https://packagist.org/packages/rarog/user-rbac)
[![Scrutinizer](https://scrutinizer-ci.com/g/ojhaujjwal/UserRbac/badges/quality-score.png?s=cb02df4e08a5df08c1ec74d1e483fbd347da154f)](https://scrutinizer-ci.com/g/ojhaujjwal/UserRbac/)
[![Code Coverage](https://scrutinizer-ci.com/g/ojhaujjwal/UserRbac/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ojhaujjwal/UserRbac/?branch=master)

A Zend Framework module to easily integrate [ZfcUser](https://github.com/ZF-Commons/ZfcUser) and [ZfcRbac](https://github.com/ZF-Commons/zfc-rbac)

##Introduction
Are your tired of doing tedious work of integrating ZfcUser and ZfcRbac again and again? Then, you are in the right place. This module comes to save us. This module, simply, gets roles of a user from the database and passes it to the ZfcRbac. You only need to focus on the domain logic of your application. No more repetive tasks.

##Versions
Please use below table to figure out what version of ZfcUser you should use.

| UserRbac version | Supported Zend Framework version |
|------------------|----------------------------------|
| 0.x              | <= 2.5                           |
| 1.x              | >= 2.6 or 3.x                    |

## Features
1. No need to write code for integrating ZfcUser and ZfcRbac
2. A user`s roles are easily retrievable from the database
3. Addition of `SmartRedirectStrategy`

## Installation
* Add `"rarog/user-rbac": "dev-master",` to your composer.json and run `php composer.phar update`
* Import the schema for corresponding database in `data` folder
* Enable this module in `config/application.config.php`
* Copy file located in `vendor/rarog/user-rbac/config/user-rbac.global.php.dist` to `./config/autoload/user-rbac.global.php` and change the values as you wish

## Important notice
There is no release from the 2.x branch of [ZfcUser](https://github.com/ZF-Commons/ZfcUser/tree/2.x), so UserRbac 1.x requires the latest HEAD of its branch as of now (commit 4351884). There might, backward compatibility might be broken in the future, so UserRbac will be updated accordingly.

## What it does
This module registers an identity provider and provides some configuration to ZfcRbac. So, you don't need to create your own identity provider. See [`config/module.config.php`](https://github.com/rarog/UserRbac/blob/master/config/module.config.php#L4).

## How it works
It gets a user's roles from the table `user_role_linker` and passes the roles to `ZfcRbac`. This module is best suited when you use `ZfcRbac\Role\InMemoryRoleProvider` as role provider.

## Options
Check the options available in `vendor/rarog/user-rbac/config/user-rbac.global.php.dist`. 

## SmartRedirectStrategy

This module comes with a new strategy called `SmartRedirectStrategy`. This simply redirects to `ZfcUser`'s login page or route, `zfcuser/login` only when the user is unauthenticated. Otherwise, it shows a 403 error page!

#### Usage
```php
public function onBootstrap(EventInterface $e)
{
    $t = $e->getTarget();

    $t->getEventManager()->attach(
        $t->getServiceManager()->get('UserRbac\View\Strategy\SmartRedirectStrategy')
    );
}
```

## Known Limitation
This module is only ideal for small and medium web sites as a quick and easy way. For complicated use cases, it may not suit your need.

