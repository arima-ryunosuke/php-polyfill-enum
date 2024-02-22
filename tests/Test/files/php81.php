<?php

namespace enums;

use ryunosuke\polyfill\enum\IntBackedEnum;
use ryunosuke\polyfill\enum\PureEnum;
use ryunosuke\polyfill\enum\StringBackedEnum;

enum PureEnum1
{
    case case;
}

final class PureEnum2 extends PureEnum
{
    const case = null;
}

enum IntEnum1: int
{
    case case = 1;
}

final class IntEnum2 extends IntBackedEnum
{
    const case = 1;
}

enum StringEnum1: string
{
    case case = 'a';
}

final class StringEnum2 extends StringBackedEnum
{
    const case = 'a';
}
