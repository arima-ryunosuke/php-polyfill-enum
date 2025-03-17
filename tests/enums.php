<?php

use ryunosuke\polyfill\enum\attributes\EnumCase;
use ryunosuke\polyfill\enum\IntBackedEnum;
use ryunosuke\polyfill\enum\PureEnum;
use ryunosuke\polyfill\enum\StringBackedEnum;
use ryunosuke\polyfill\enum\traits\Compatible;
use ryunosuke\utility\enum\attributes\Label;
use ryunosuke\utility\enum\traits\Arrayable;
use ryunosuke\utility\enum\traits\Convertible;
use ryunosuke\utility\enum\traits\Labelable;

final class Suite extends PureEnum
{
    use Compatible;

    protected const DUMMY    = 'dummy';
    protected const constant = 123;

    const Hearts   = null;
    const Diamonds = null;
    const Clubs    = null;
    const Spades   = null;
}

final class Size extends IntBackedEnum
{
    use Compatible;

    protected const DUMMY = 'dummy';

    const Small  = 10;
    const Medium = 20;
    const Large  = 30;
}

final class Level extends StringBackedEnum
{
    use Compatible;

    protected const DUMMY = 'dummy';

    const Easy   = 'easy';
    const Normal = 'normal';
    const Hard   = 'hard';
}

final class UtilityEnum extends StringBackedEnum
{
    use Compatible;
    use Arrayable;
    use Labelable;
    use Convertible;

    protected const DUMMY = 'dummy';

    const A = 'a';
    #[Label("labelB")]
    const B = 'b';
    const C = 'c';

    #[EnumCase(false)]
    const Z = 'z';

    public function label(): ?string
    {
        return match ($this->value) {
            self::A => "label" . str_repeat(strtoupper($this->value), 3),
            default => null,
        };
    }
}

final class OkStringEnum extends StringBackedEnum
{
    use Compatible;

    const A = 'a';
    const B = 'b';
    const C = 'c';
}

final class NoStringEnum extends StringBackedEnum
{
    use Compatible;

    const A = 'a';
    const B = 'b';
    const C = 3;
}

final class PropertyEnum extends IntBackedEnum
{
    use Compatible;

    protected $otherProperty;

    const A = 1;
    const B = 2;
    const C = 3;
}

class NoFinalEnum extends IntBackedEnum
{
    use Compatible;

    const A = 1;
    const B = 2;
    const C = 3;
}

final class HasMagicEnum extends IntBackedEnum
{
    use Compatible;

    const A = 1;
    const B = 2;
    const C = 3;

    public function __toString()
    {
        return '';
    }
}
