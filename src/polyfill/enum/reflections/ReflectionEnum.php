<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\polyfill\enum\reflections;

use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ryunosuke\polyfill\enum\attributes\EnumCase;
use ryunosuke\polyfill\enum\interfaces\BackedEnum;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;

class ReflectionEnum extends ReflectionClass
{
    public function __construct(object|string $objectOrClass)
    {
        $classname = is_object($objectOrClass) ? get_class($objectOrClass) : $objectOrClass;
        if (!class_exists($classname) || (!is_a($classname, UnitEnum::class, true) && !is_a($classname, \UnitEnum::class, true))) {
            throw new ReflectionException("Class \"$classname\" is not an enum");
        }

        parent::__construct($objectOrClass);
    }

    public function getBackingType(): ?ReflectionNamedType
    {
        if ($this->isBacked()) {
            $that = $this;
            if (is_a($this->name, BackedEnum::class, true)) {
                $that = $this->getParentClass();
            }
            return $that->getProperty('value')->getType();
        }
        return null;
    }

    public function getCase(string $name): ReflectionEnumUnitCase
    {
        if (!$this->hasCase($name)) {
            throw new ReflectionException("{$this->name}::$name is not a case");
        }

        if ($this->isBacked()) {
            return new ReflectionEnumBackedCase($this->name, $name);
        }
        else {
            return new ReflectionEnumUnitCase($this->name, $name);
        }
    }

    public function getCases(): array
    {
        $cases = [];
        foreach ($this->getConstants() as $name => $const) {
            if ($this->hasCase($name)) {
                $cases[] = $this->getCase($name);
            }
        }
        return $cases;
    }

    public function hasCase(string $name): bool
    {
        $refconst = $this->getReflectionConstant($name);

        if ($refconst === false) {
            return false;
        }

        if (!$refconst->isPublic()) {
            return false;
        }

        // check type
        if (!("is_" . @strval($this->getBackingType() ?? 'null'))($refconst->getValue())) {
            // It may have already been rewritten by uopz_redefine. and const can have object from 8.1
            if (!is_a($refconst->getValue(), $this->name)) {
                return false; // @codeCoverageIgnore
            }
        }

        // this is impossible since inheritance is prohibited. but uopz_redefine seems to redefine inherit tree also
        if ($refconst->getDeclaringClass()->name !== $this->name) {
            return false; // @codeCoverageIgnore
        }

        // check by attribute
        $attribute = EnumCase::of($refconst);
        if (isset($attribute[0])) {
            return $attribute[0]->getArguments()[0];
        }

        return true;
    }

    public function isBacked(): bool
    {
        return is_a($this->name, BackedEnum::class, true) || is_a($this->name, \BackedEnum::class, true);
    }
}
