<?php
namespace ryunosuke\Test\enum\traits;

use ryunosuke\Test\enum\concrete\RedefineEnum;

class InitializableTest extends \ryunosuke\Test\AbstractTestCase
{
    function test___autoload()
    {
        if (function_exists('uopz_redefine')) {
            that(RedefineEnum::A())->isSame(RedefineEnum::A);
        }
    }
}
