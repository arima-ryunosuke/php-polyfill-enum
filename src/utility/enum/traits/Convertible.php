<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\utility\enum\traits;

use ryunosuke\polyfill\enum\interfaces\UnitEnum;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ValueError;

trait Convertible
{
    /**
     * convert name to enum case
     */
    public static function caseOf(string $name): UnitEnum|\UnitEnum
    {
        $refenum = new ReflectionEnum(static::class);
        return $refenum->getCase($name)->getValue();
    }

    /**
     * convert name to BackedEnum value
     */
    public static function valueOf(string $name): null|int|string
    {
        return static::caseOf($name)->value ?? null;
    }

    /**
     * convert any value to enum case
     */
    public static function normalize(mixed $case, bool $throwable = true): ?static
    {
        if ($case instanceof self) {
            return $case;
        }

        if (!is_int($case) && !is_string($case) && !(is_object($case) && method_exists($case, '__toString'))) {
            return $throwable ? throw new ValueError(sprintf('null is not a valid backing value for enum "%s"', static::class)) : null;
        }

        $case = static::tryFrom($case);

        if ($case === null) {
            return $throwable ? throw new ValueError(sprintf('null is not a valid backing value for enum "%s"', static::class)) : null;
        }

        return $case;
    }

    /**
     * convert any values to enum cases
     *
     * @return array<?static>
     */
    public static function normalizeArray(array $cases, bool $throwable = true): array
    {
        return array_map(fn($case) => static::normalize($case, $throwable), $cases);
    }
}
