<?php
namespace ryunosuke\Test\polyfill\enum\reflections;

use Level;
use ReflectionException;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ryunosuke\polyfill\enum\reflections\ReflectionEnumBackedCase;
use ryunosuke\polyfill\enum\reflections\ReflectionEnumUnitCase;
use Size;
use stdClass;
use Suite;

class ReflectionEnumTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_constructor()
    {
        that(ReflectionEnum::class)->new(stdClass::class)->wasThrown('Class "stdClass" is not an enum');
    }

    function test_getBackingType()
    {
        that(new ReflectionEnum(Suite::class))->getBackingType()->is(null);
        that(new ReflectionEnum(Size::class))->getBackingType()->getName()->is('int');
        that(new ReflectionEnum(Level::class))->getBackingType()->getName()->is('string');
    }

    function test_getCase()
    {
        that(new ReflectionEnum(Suite::class))->getCase('Hearts')->isInstanceOf(ReflectionEnumUnitCase::class);
        that(new ReflectionEnum(Size::class))->getCase('Small')->isInstanceOf(ReflectionEnumBackedCase::class);
        that(new ReflectionEnum(Level::class))->getCase('Normal')->isInstanceOf(ReflectionEnumBackedCase::class);

        that(new ReflectionEnum(Suite::class))->getCase('constant')->wasThrown(new ReflectionException('Suite::constant is not a case', 0));
    }

    function test_getCases()
    {
        that(new ReflectionEnum(Suite::class))->getCases()->count(4)->eachIsInstanceOf(ReflectionEnumUnitCase::class);
        that(new ReflectionEnum(Size::class))->getCases()->count(3)->eachIsInstanceOf(ReflectionEnumBackedCase::class);
        that(new ReflectionEnum(Level::class))->getCases()->count(3)->eachIsInstanceOf(ReflectionEnumBackedCase::class);
    }

    function test_hasCase()
    {
        that(new ReflectionEnum(Suite::class))->hasCase('Hearts')->is(true);
        that(new ReflectionEnum(Size::class))->hasCase('Small')->is(true);
        that(new ReflectionEnum(Level::class))->hasCase('Normal')->is(true);

        that(new ReflectionEnum(Suite::class))->hasCase('undefined')->is(false);
        that(new ReflectionEnum(Size::class))->hasCase('undefined')->is(false);
        that(new ReflectionEnum(Level::class))->hasCase('undefined')->is(false);
    }

    function test_isBacked()
    {
        that(new ReflectionEnum(Suite::class))->isBacked()->is(false);
        that(new ReflectionEnum(Size::class))->isBacked()->is(true);
        that(new ReflectionEnum(Level::class))->isBacked()->is(true);
    }
}
