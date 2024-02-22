<?php
namespace ryunosuke\polyfill\enum\traits;

/**
 * @internal
 */
trait Enumable
{
    use Methodable;

    public function __isset($name)
    {
        // Practically only name and value (because enums cannot have properties)
        return property_exists($this, $name);
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        trigger_error(sprintf('Undefined property: %s::$%s', static::class, $name), E_USER_WARNING);
    }

    public function __debugInfo()
    {
        return get_object_vars($this);
    }
}
