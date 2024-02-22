<?php
/**
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
namespace ryunosuke\Test\enum;

use ryunosuke\polyfill\enum\interfaces\BackedEnum;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;
use Size;

class IntBackedEnumTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_instanceof()
    {
        that(Size::Small())->isInstanceOf(UnitEnum::class);
        that(Size::Small())->isInstanceOf(BackedEnum::class);
    }

    function test_methodable()
    {
        that(Size::Small())->isInstanceOf(Size::class);
        that(Size::Medium())->isInstanceOf(Size::class);
        that(Size::Large())->isInstanceOf(Size::class);
        that(Size::Undefined())->is(null);
    }

    function test_name()
    {
        that(Size::Small()->name)->is('Small');
        that(Size::Medium()->name)->is('Medium');
        that(Size::Large()->name)->is('Large');
    }

    function test_value()
    {
        that(Size::Small()->value)->is(10);
        that(Size::Medium()->value)->is(20);
        that(Size::Large()->value)->is(30);
    }

    function test_cases()
    {
        that(Size::cases())->isSame([
            Size::Small(),
            Size::Medium(),
            Size::Large(),
        ]);
    }

    function test_from()
    {
        that(Size::from(10))->isSame(Size::Small());
        that(Size::from(20))->isSame(Size::Medium());
        that(Size::from(30))->isSame(Size::Large());

        that(Size::class)::from(999)->wasThrown('999 is not a valid backing value for enum "Size"');
    }

    function test_tryFrom()
    {
        that(Size::tryFrom(10))->isSame(Size::Small());
        that(Size::tryFrom(20))->isSame(Size::Medium());
        that(Size::tryFrom(30))->isSame(Size::Large());
        that(Size::tryFrom(999))->isSame(null);
    }

    function test_json()
    {
        that(json_encode(Size::Small()))->isSame('10');
        that(json_encode(Size::Medium()))->isSame('20');
        that(json_encode(Size::Large()))->isSame('30');
    }

    function test___toString()
    {
        that(fn() => strval(Size::Small()))()->wasThrown('Object of class Size could not be converted to string');
    }
}
