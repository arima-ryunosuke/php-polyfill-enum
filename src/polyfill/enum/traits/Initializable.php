<?php /** @noinspection PhpUndefinedMethodInspection */
namespace ryunosuke\polyfill\enum\traits;

trait Initializable
{
    public static function __autoload()
    {
        static $autoloaded = false;
        if (!$autoloaded) {
            $autoloaded = true;
            if (method_exists(static::class, 'assert')) {
                static::assert();
            }
            if (method_exists(static::class, 'redefine')) {
                static::redefine();
            }
        }
    }
}
