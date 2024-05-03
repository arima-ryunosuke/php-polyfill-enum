<?php
namespace ryunosuke\polyfill\enum\traits;

use LogicException;
use ReflectionMethod;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;

trait Compatible
{
    final public static function assert(): void
    {
        // do assertion mode only
        assert((function () {
            $refclass = new ReflectionEnum(static::class);

            // check other property
            if ($refclass->getProperties()) {
                throw new LogicException('Enums must not include properties');
            }

            // check final
            if (!$refclass->isFinal()) {
                throw new LogicException('Enums should be final class');
            }

            // check magic method
            $magics = [
                '__construct'   => false,
                '__destruct'    => false,
                '__call'        => true, // allowed
                '__callStatic'  => true, // allowed
                '__get'         => false,
                '__set'         => false,
                '__isset'       => false,
                '__unset'       => false,
                '__sleep'       => false,
                '__wakeup'      => false,
                '__serialize'   => false,
                '__unserialize' => false,
                '__toString'    => false,
                '__invoke'      => true, // allowed
                '__set_state'   => false,
                '__clone'       => false,
                '__debugInfo'   => false,
            ];
            foreach ($magics as $name => $allowed) {
                if (!$allowed && $refclass->hasMethod($name)) {
                    $method = new ReflectionMethod(static::class, $name);
                    // allow only this package trait method
                    if (dirname($method->getFileName()) !== __DIR__) {
                        throw new LogicException(sprintf('Enum may not include %s', $name));
                    }
                }
            }

            return true;
        })());
    }

    final public static function redefine(): void
    {
        if (version_compare(PHP_VERSION, 8.1) < 0 && function_exists('uopz_redefine')) {
            foreach ((new ReflectionEnum(static::class))->getCases() as $refcase) {
                $case = $refcase->getValue();
                /** @noinspection PhpUndefinedFunctionInspection */
                uopz_redefine(static::class, $case->name, $case); // notice: uopz_redefine seems to redefine inherit tree also
            }
        }
    }
}
