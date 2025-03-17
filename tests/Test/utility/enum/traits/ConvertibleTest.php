<?php
namespace ryunosuke\Test\utility\enum\traits;

use UtilityEnum;

class ConvertibleTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_xOf()
    {
        that(UtilityEnum::caseOf('A'))->isSame(UtilityEnum::A());
        that(UtilityEnum::valueOf('A'))->isSame('a');

        that(UtilityEnum::class)::caseOf('x')->wasThrown('x is not a case');
    }

    function test_normalize()
    {
        that(UtilityEnum::normalize(null, false))->isSame(null);
        that(UtilityEnum::normalize([], false))->isSame(null);
        that(UtilityEnum::normalize('x', false))->isSame(null);
        that(UtilityEnum::normalize('a'))->isSame(UtilityEnum::A());
        that(UtilityEnum::normalize(UtilityEnum::A()))->isSame(UtilityEnum::A());

        that(UtilityEnum::normalizeArray([
            'k1' => 'x',
            'k2' => 'a',
            'k3' => UtilityEnum::A(),
        ], false))->isSame([
            "k1" => null,
            "k2" => UtilityEnum::A(),
            "k3" => UtilityEnum::A(),
        ]);

        that(UtilityEnum::class)::normalize(null)->wasThrown('null is not a valid');
        that(UtilityEnum::class)::normalize([])->wasThrown('null is not a valid');
        that(UtilityEnum::class)::normalize('x')->wasThrown('null is not a valid');

        that(UtilityEnum::class)::normalizeArray([
            'k1' => 'x',
            'k2' => 'a',
            'k3' => UtilityEnum::A(),
        ])->wasThrown('null is not a valid');
    }
}
