<?php
/**
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
namespace ryunosuke\Test\polyfill\enum;

use Level;
use ryunosuke\polyfill\enum\interfaces\BackedEnum;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;

class StringBackedEnumTest extends \ryunosuke\Test\AbstractTestCase
{
    function test___set_state()
    {
        $expr = "return " . var_export(Level::cases(), true) . ";";
        that(eval($expr))->isSame(Level::cases());
    }

    function test_instanceof()
    {
        that(Level::Easy())->isInstanceOf(UnitEnum::class);
        that(Level::Easy())->isInstanceOf(BackedEnum::class);
    }

    function test_name()
    {
        that(Level::Easy()->name)->is('Easy');
        that(Level::Normal()->name)->is('Normal');
        that(Level::Hard()->name)->is('Hard');
    }

    function test_value()
    {
        that(Level::Easy()->value)->is('easy');
        that(Level::Normal()->value)->is('normal');
        that(Level::Hard()->value)->is('hard');
    }

    function test_cases()
    {
        that(Level::cases())->isSame([
            Level::Easy(),
            Level::Normal(),
            Level::Hard(),
        ]);
    }

    function test_from()
    {
        that(Level::from('easy'))->isSame(Level::Easy());
        that(Level::from('normal'))->isSame(Level::Normal());
        that(Level::from('hard'))->isSame(Level::Hard());

        that(Level::class)::from('undefined')->wasThrown('"undefined" is not a valid backing value for enum "Level"');
    }

    function test_tryFrom()
    {
        that(Level::tryFrom('easy'))->isSame(Level::Easy());
        that(Level::tryFrom('normal'))->isSame(Level::Normal());
        that(Level::tryFrom('hard'))->isSame(Level::Hard());
        that(Level::tryFrom('undefined'))->isSame(null);
    }

    function test_json()
    {
        that(json_encode(Level::Easy()))->isSame('"easy"');
        that(json_encode(Level::Normal()))->isSame('"normal"');
        that(json_encode(Level::Hard()))->isSame('"hard"');
    }

    function test___toString()
    {
        that(fn() => strval(Level::Easy()))()->wasThrown('Object of class Level could not be converted to string');
    }
}
