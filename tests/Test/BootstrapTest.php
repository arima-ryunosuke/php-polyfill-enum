<?php
namespace ryunosuke\Test;

use ArrayObject;
use Level;
use ReflectionClass;
use Size;
use stdClass;
use Suite;
use UtilityEnum;

class BootstrapTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_enum_exists()
    {
        if (version_compare(PHP_VERSION, 8.1) < 0) {
            that(enum_exists(Level::class))->isTrue();
            that(enum_exists(Suite::class))->isTrue();
            that(enum_exists(Size::class))->isTrue();
            that(enum_exists(stdClass::class))->isFalse();
            that(enum_exists('undefined'))->isFalse();
        }
    }

    function test_ReflectionClassConstant_isEnumCase()
    {
        $refclass = new ReflectionClass(UtilityEnum::class);
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('DUMMY')))->isFalse();
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('A')))->isTrue();
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('B')))->isTrue();
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('C')))->isTrue();
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('Z')))->isFalse();

        $refclass = new ReflectionClass(ArrayObject::class);
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('STD_PROP_LIST')))->isFalse();
        that(ReflectionClassConstant_isEnumCase($refclass->getReflectionConstant('ARRAY_AS_PROPS')))->isFalse();
    }
}
