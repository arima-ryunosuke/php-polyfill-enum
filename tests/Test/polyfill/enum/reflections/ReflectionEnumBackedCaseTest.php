<?php
namespace ryunosuke\Test\polyfill\enum\reflections;

use Level;
use ReflectionException;
use ryunosuke\polyfill\enum\reflections\ReflectionEnumBackedCase;
use Size;
use Suite;

class ReflectionEnumBackedCaseTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_getBackingValue()
    {
        that(ReflectionEnumBackedCase::class)->new(Suite::class, 'Hearts')->wasThrown(new ReflectionException('Enum case Suite::Hearts is not a backed case', 0));
        that(new ReflectionEnumBackedCase(Size::class, 'Small'))->getBackingValue()->is(10);
        that(new ReflectionEnumBackedCase(Level::class, 'Normal'))->getBackingValue()->is('normal');
    }
}
