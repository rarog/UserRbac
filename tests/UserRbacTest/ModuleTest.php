<?php
namespace UserRbacTest;

use PHPUnit\Framework\TestCase;
use UserRbac\Module;

class ModuleTest extends TestCase
{

    public function testConfigIsArray()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
        $this->assertInternalType('array', $module->getServiceConfig());
    }
}
