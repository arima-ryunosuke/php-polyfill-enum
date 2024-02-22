<?php
/**
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
namespace ryunosuke\polyfill\enum\traits;

trait Methodable
{
    public static function __callStatic($name, $arguments)
    {
        foreach (static::cases() as $case) {
            if ($name === $case->name) {
                return $case;
            }
        }

        // Throwing an exception here will complicate things when overriding, so return null
        return null;
    }
}
