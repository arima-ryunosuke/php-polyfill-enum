<?php
namespace ryunosuke\polyfill\enum\interfaces;

interface BackedEnum extends UnitEnum
{
    /**
     * @param int|string $value
     * @return static
     * @throws \ValueError
     */
    public static function from($value): self;

    /**
     * @param int|string $value
     * @return ?static
     */
    public static function tryFrom($value): ?self;
}
