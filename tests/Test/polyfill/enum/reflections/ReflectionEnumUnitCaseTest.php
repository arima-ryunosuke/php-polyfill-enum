<?php
namespace ryunosuke\Test\polyfill\enum\reflections;

use Level;
use ReflectionException;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ryunosuke\polyfill\enum\reflections\ReflectionEnumUnitCase;
use Size;
use Suite;

class ReflectionEnumUnitCaseTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_constructor()
    {
        that(ReflectionEnumUnitCase::class)->new(Suite::class, 'constant')->wasThrown(new ReflectionException('Suite::constant is not a case', 0));
    }

    function test_getEnum()
    {
        that(new ReflectionEnumUnitCase(Suite::class, 'Hearts'))->getEnum()->isInstanceOf(ReflectionEnum::class);
        that(new ReflectionEnumUnitCase(Size::class, 'Small'))->getEnum()->isInstanceOf(ReflectionEnum::class);
        that(new ReflectionEnumUnitCase(Level::class, 'Normal'))->getEnum()->isInstanceOf(ReflectionEnum::class);
    }

    function test_getValue()
    {
        that(new ReflectionEnumUnitCase(Suite::class, 'Hearts'))->getValue()->isSame(Suite::Hearts());
        that(new ReflectionEnumUnitCase(Size::class, 'Small'))->getValue()->isSame(Size::Small());
        that(new ReflectionEnumUnitCase(Level::class, 'Normal'))->getValue()->isSame(Level::Normal());
    }
}
