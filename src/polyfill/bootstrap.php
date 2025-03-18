<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */

if (!function_exists('enum_exists')) {
    function enum_exists(string $enum, bool $autoload = true): bool
    {
        if (!class_exists($enum, $autoload)) {
            return false;
        }

        return is_a($enum, UnitEnum::class, true);
    }
}
if (!function_exists('ReflectionClassConstant_isEnumCase')) {
    function ReflectionClassConstant_isEnumCase(ReflectionClassConstant $that): bool
    {
        $classname = $that->getDeclaringClass()->name;
        if (!class_exists($classname) || (!is_a($classname, \ryunosuke\polyfill\enum\interfaces\UnitEnum::class, true) && !is_a($classname, UnitEnum::class, true))) {
            return false;
        }
        return (new \ryunosuke\polyfill\enum\reflections\ReflectionEnum($classname))->hasCase($that->name);
    }
}
