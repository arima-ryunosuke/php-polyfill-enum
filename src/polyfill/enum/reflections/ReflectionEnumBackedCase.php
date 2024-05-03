<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\polyfill\enum\reflections;

use ReflectionException;

class ReflectionEnumBackedCase extends ReflectionEnumUnitCase
{
    public function __construct(object|string $class, string $constant)
    {
        parent::__construct($class, $constant);

        if (!$this->getEnum()->isBacked()) {
            throw new ReflectionException("Enum case {$this->class}::{$this->name} is not a backed case");
        }
    }

    public function getBackingValue(): int|string
    {
        $const = $this->getDeclaringClass()->getConstant($this->name);

        // for uopz or php8.1
        if ($const instanceof \BackedEnum) {
            return $const->value; // @codeCoverageIgnore
        }

        return $const;
    }
}
