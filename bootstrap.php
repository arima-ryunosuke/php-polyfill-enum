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

// autoload for Initializable::__autoload
(function () {
    $loading = false;
    spl_autoload_register($self = function (string $class) use (&$self, &$loading) {
        // recursion prevention. other spl_autoload_function may call spl_autoload_functions
        if (!$loading) {
            $loading = true;
            foreach (spl_autoload_functions() as $loader) {
                if ($loader !== $self) {
                    $loader($class);
                    if (class_exists($class, false) || interface_exists($class, false) || trait_exists($class, false)) {
                        break;
                    }
                }
            }
            $loading = false;
        }

        if (class_exists($class, false) && method_exists($class, '__autoload')) {
            $methodFile = (new ReflectionMethod($class, '__autoload'))->getFileName();
            $traitFile  = (new ReflectionClass(\ryunosuke\polyfill\enum\traits\Initializable::class))->getFileName();
            if ($methodFile === $traitFile) {
                $class::__autoload();
            }
        }
    }, true, true);
})();
