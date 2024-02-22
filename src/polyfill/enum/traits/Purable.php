<?php
namespace ryunosuke\polyfill\enum\traits;

use JsonException;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;

/**
 * @internal
 */
trait Purable
{
    use Enumable;

    final private function __construct($name)
    {
        assert(defined(static::class . "::$name"));

        $this->name = $name;
    }

    final public static function cases(): array
    {
        return array_map(fn($refcase) => $refcase->getValue(), (new ReflectionEnum(static::class))->getCases());
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        throw new JsonException("Non-backed enums have no default serialization");
    }
}
