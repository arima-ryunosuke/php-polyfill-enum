<?php
namespace ryunosuke\polyfill\enum\interfaces;

interface UnitEnum
{
    /** @return static[] */
    public static function cases(): array;
}
