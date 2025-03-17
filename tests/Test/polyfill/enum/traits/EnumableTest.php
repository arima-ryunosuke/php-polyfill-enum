<?php
namespace ryunosuke\Test\polyfill\enum\traits;

use Level;
use Size;
use Suite;

class EnumableTest extends \ryunosuke\Test\AbstractTestCase
{
    function test___isset()
    {
        $hearts = Suite::Hearts();
        that(isset($hearts->name))->isTrue();
        that(isset($hearts->hoge))->isFalse();
    }

    function test___get()
    {
        $hearts = Suite::Hearts();
        that($hearts->name)->is('Hearts');

        @that($hearts->value)->isNull();
        that(error_get_last()['message'])->is('Undefined property: Suite::$value');
    }

    function test___debugInfo()
    {
        that(print_r(Suite::Hearts(), true))->contains("[name] => Hearts")->notContains("[value]");
        that(print_r(Size::Small(), true))->contains("[name] => Small")->contains("[value] => 10");
        that(print_r(Level::Normal(), true))->contains("[name] => Normal")->contains("[value] => normal");
    }
}
