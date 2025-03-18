<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\ponyfill;

function enum_exists(string $enum, bool $autoload = true): bool
{
    if (!class_exists($enum, $autoload)) {
        return false;
    }

    return is_a($enum, \UnitEnum::class, true)
        || is_a($enum, \ryunosuke\polyfill\enum\interfaces\UnitEnum::class, true);
}

function instanceof_UnitEnum(mixed $object_or_class): bool
{
    return is_a($object_or_class, \UnitEnum::class, false)
        || is_a($object_or_class, \ryunosuke\polyfill\enum\interfaces\UnitEnum::class, false);
}

function instanceof_BackedEnum(mixed $object_or_class): bool
{
    return is_a($object_or_class, \BackedEnum::class, false)
        || is_a($object_or_class, \ryunosuke\polyfill\enum\interfaces\BackedEnum::class, false);
}
