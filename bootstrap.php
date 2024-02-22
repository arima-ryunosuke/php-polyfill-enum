<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */

if (!interface_exists(UnitEnum::class)) {
    class_alias(\ryunosuke\polyfill\enum\interfaces\UnitEnum::class, UnitEnum::class);
}
if (!interface_exists(BackedEnum::class)) {
    class_alias(\ryunosuke\polyfill\enum\interfaces\BackedEnum::class, BackedEnum::class);
}
if (!class_exists(ReflectionEnum::class)) {
    class_alias(\ryunosuke\polyfill\enum\reflections\ReflectionEnum::class, ReflectionEnum::class);
}
if (!class_exists(ReflectionEnumUnitCase::class)) {
    class_alias(\ryunosuke\polyfill\enum\reflections\ReflectionEnumUnitCase::class, ReflectionEnumUnitCase::class);
}
if (!class_exists(ReflectionEnumBackedCase::class)) {
    class_alias(\ryunosuke\polyfill\enum\reflections\ReflectionEnumBackedCase::class, ReflectionEnumBackedCase::class);
}
if (!class_exists(ValueError::class)) {
    class ValueError extends Error { }
}

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

// autoload for Initializable::__autoload
(function () {
    spl_autoload_register($self = function (string $class) use (&$self) {
        foreach (spl_autoload_functions() as $loader) {
            if ($loader !== $self) {
                $loader($class);
                if (class_exists($class, false) && method_exists($class, '__autoload')) {
                    $methodFile = (new ReflectionMethod($class, '__autoload'))->getFileName();
                    $traitFile  = (new ReflectionClass(\ryunosuke\polyfill\enum\traits\Initializable::class))->getFileName();
                    if ($methodFile === $traitFile) {
                        $class::__autoload();
                    }
                    break;
                }
            }
        }
    }, true, true);
})();
