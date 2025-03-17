<?php
namespace ryunosuke\utility\enum\traits;

trait Arrayable
{
    /**
     * get [name => case, ...]
     *
     * @return array{string: static}
     */
    public static function nameCases(): array
    {
        return array_column(static::cases(), null, 'name');
    }

    /**
     * get [name => value, ...]
     *
     * @return array{string: int|string}
     */
    public static function nameValues(): array
    {
        return array_column(static::cases(), 'value', 'name');
    }

    /**
     * get [name, ...]
     *
     * @return array<string>
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * get [value, ...]
     *
     * @return array<int|string>
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }
}
