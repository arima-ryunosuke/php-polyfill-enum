<?php
namespace ryunosuke\polyfill\enum\interfaces;

interface BackedEnum extends UnitEnum
{
    public static function from(int|string $value): static;

    public static function tryFrom(int|string $value): ?static;
}
