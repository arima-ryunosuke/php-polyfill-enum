<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\polyfill\enum\reflections;

use ReflectionException;

class ReflectionEnumBackedCase extends ReflectionEnumUnitCase
{
    /** @param object|string $class */
    public function __construct($class, string $constant)
    {
        parent::__construct($class, $constant);

        if (!$this->getEnum()->isBacked()) {
            throw new ReflectionException("Enum case {$this->class}::{$this->name} is not a backed case");
        }
    }

    /** @return int|string */
    #[\ReturnTypeWillChange]
    public function getBackingValue()
    {
        $const = $this->getDeclaringClass()->getConstant($this->name);

        // for uopz or php8.1
        if ($const instanceof \BackedEnum) {
            return $const->value; // @codeCoverageIgnore
        }

        return $const;
    }
}
