<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\polyfill\enum\reflections;

use ReflectionClassConstant;
use ReflectionException;
use ryunosuke\polyfill\enum\interfaces\UnitEnum;

class ReflectionEnumUnitCase extends ReflectionClassConstant
{
    static private $instances = [];

    /** @param object|string $class */
    public function __construct($class, string $constant)
    {
        parent::__construct($class, $constant);

        if (!$this->getEnum()->hasCase($constant)) {
            throw new ReflectionException("{$this->class}::$constant is not a case");
        }
    }

    public function getEnum(): ReflectionEnum
    {
        return new ReflectionEnum($this->class);
    }

    /** @return UnitEnum|\UnitEnum */
    #[\ReturnTypeWillChange]
    public function getValue()
    {
        // for uopz or php8.1
        if (($const = $this->getDeclaringClass()->getConstant($this->name)) instanceof \UnitEnum) {
            return $const; // @codeCoverageIgnore
        }

        if (!isset(self::$instances[$this->class][$this->name])) {
            $instance = $this->getDeclaringClass()->newInstanceWithoutConstructor();
            $ctor     = $this->getDeclaringClass()->getConstructor();
            $ctor->setAccessible(true);
            $ctor->invoke($instance, $this->name);
            self::$instances[$this->class][$this->name] = $instance;
        }
        return self::$instances[$this->class][$this->name];
    }
}
