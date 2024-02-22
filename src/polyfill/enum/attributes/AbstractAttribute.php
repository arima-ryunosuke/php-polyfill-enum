<?php
namespace ryunosuke\polyfill\enum\attributes;

use Attribute;
use ReflectionAttribute;

#[Attribute(Attribute::TARGET_ALL)]
class AbstractAttribute
{
    /** @return ReflectionAttribute[] */
    public static function of($reflection): array
    {
        if (method_exists($reflection, 'getAttributes')) {
            return $reflection->getAttributes(static::class); // @codeCoverageIgnore
        }

        if (class_exists(\ryunosuke\polyfill\attribute\Provider::class)) {
            static $provider = null;
            $provider ??= new \ryunosuke\polyfill\attribute\Provider();
            return $provider->getAttributes($reflection, static::class);
        }

        return []; // @codeCoverageIgnore
    }
}
