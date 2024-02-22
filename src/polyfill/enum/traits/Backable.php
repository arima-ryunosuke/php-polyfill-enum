<?php
namespace ryunosuke\polyfill\enum\traits;

use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ValueError;

/**
 * @internal
 */
trait Backable
{
    use Enumable;

    final private function __construct($name)
    {
        assert(defined(static::class . "::$name"));

        $this->name  = $name;
        $this->value = constant(static::class . "::$name");
    }

    final public static function cases(): array
    {
        return array_map(fn($refcase) => $refcase->getValue(), (new ReflectionEnum(static::class))->getCases());
    }

    final public static function from($value): self
    {
        $case = static::tryFrom($value);
        if ($case === null) {
            throw new ValueError(sprintf('%s is not a valid backing value for enum "%s"', json_encode($value), static::class));
        }
        return $case;
    }

    final public static function tryFrom($value): ?self
    {
        foreach (static::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->value;
    }
}
