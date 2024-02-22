<?php
namespace ryunosuke\polyfill\enum;

use JsonSerializable;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;

/**
 * @property-read string $name
 */
class PureEnum implements UnitEnum, JsonSerializable
{
    use traits\Purable;

    private string $name;
}
