<?php
namespace ryunosuke\Test\utility\enum\traits;

use UtilityEnum;

class ArrayableTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_all()
    {
        that(UtilityEnum::nameCases())->isSame([
            "A" => UtilityEnum::A(),
            "B" => UtilityEnum::B(),
            "C" => UtilityEnum::C(),
        ]);

        that(UtilityEnum::nameValues())->isSame([
            "A" => "a",
            "B" => "b",
            "C" => "c",
        ]);

        that(UtilityEnum::names())->isSame([
            "A",
            "B",
            "C",
        ]);

        that(UtilityEnum::values())->isSame([
            "a",
            "b",
            "c",
        ]);
    }
}
