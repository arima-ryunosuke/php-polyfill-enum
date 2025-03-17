<?php
namespace ryunosuke\Test\polyfill\enum\traits;

use ryunosuke\Test\polyfill\enum\concrete\RedefineEnum;

class InitializableTest extends \ryunosuke\Test\AbstractTestCase
{
    function test___autoload()
    {
        if (function_exists('uopz_redefine')) {
            that(RedefineEnum::A())->isSame(RedefineEnum::A);
        }
    }
}
