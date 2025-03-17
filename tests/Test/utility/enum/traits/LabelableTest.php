<?php
namespace ryunosuke\Test\utility\enum\traits;

use UtilityEnum;

class LabelableTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_all()
    {
        that(UtilityEnum::nameLabels())->isSame([
            "A" => "labelAAA",
            "B" => "labelB",
        ]);

        that(UtilityEnum::valueLabels())->isSame([
            "a" => "labelAAA",
            "b" => "labelB",
        ]);

        that(UtilityEnum::labels())->isSame([
            "labelAAA",
            "labelB",
        ]);
    }
}
