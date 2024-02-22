<?php
namespace ryunosuke\polyfill\enum;

use JsonSerializable;
use ryunosuke\polyfill\enum\interfaces\BackedEnum;

/**
 * @property-read string $name
 * @property-read int $value
 */
class IntBackedEnum implements BackedEnum, JsonSerializable
{
    use traits\Backable;

    private string $name;
    private int    $value;
}
