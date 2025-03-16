<?php
/**
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
namespace ryunosuke\Test\enum;

use ryunosuke\polyfill\enum\interfaces\BackedEnum;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;
use Suite;

class PureEnumTest extends \ryunosuke\Test\AbstractTestCase
{
    function test___set_state()
    {
        $expr = "return " . var_export(Suite::cases(), true) . ";";
        that(eval($expr))->isSame(Suite::cases());
    }

    function test_constructor()
    {
        that(Suite::class)->new('Hearts')->isInstanceOf(Suite::class);
    }

    function test_instanceof()
    {
        that(Suite::Hearts())->isInstanceOf(UnitEnum::class);
        that(Suite::Hearts())->isNotInstanceOf(BackedEnum::class);
    }

    function test_name()
    {
        that(Suite::Hearts()->name)->is('Hearts');
        that(Suite::Diamonds()->name)->is('Diamonds');
        that(Suite::Clubs()->name)->is('Clubs');
        that(Suite::Spades()->name)->is('Spades');
    }

    function test_cases()
    {
        that(Suite::cases())->isSame([
            Suite::Hearts(),
            Suite::Diamonds(),
            Suite::Clubs(),
            Suite::Spades(),
        ]);
    }

    function test_json()
    {
        that(fn() => json_encode(Suite::Hearts(), JSON_THROW_ON_ERROR))()->wasThrown('Non-backed enums have no default serialization');
    }

    function test_toString()
    {
        that(fn() => strval(Suite::Hearts()))()->wasThrown('Object of class Suite could not be converted to string');
    }
}
