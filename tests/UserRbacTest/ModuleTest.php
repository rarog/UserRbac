<?php
namespace UserRbacTest;

use UserRbac\Module;

class ModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigIsArray()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
        $this->assertInternalType('array', $module->getServiceConfig());
    }
}
