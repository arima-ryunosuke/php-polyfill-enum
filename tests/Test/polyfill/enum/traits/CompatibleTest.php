<?php
namespace ryunosuke\Test\polyfill\enum\traits;

use HasMagicEnum;
use NoFinalEnum;
use OkStringEnum;
use PropertyEnum;

class CompatibleTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_assert_ok()
    {
        that(OkStringEnum::assert())->isNull();
    }

    function test_assert_property()
    {
        that(PropertyEnum::class)::assert()->wasThrown('Enums must not include properties');
    }

    function test_assert_nofinal()
    {
        that(NoFinalEnum::class)::assert()->wasThrown('Enums should be final class');
    }

    function test_assert_magic()
    {
        that(HasMagicEnum::class)::assert()->wasThrown('Enum may not include __toString');
    }
}
