<?php
namespace ryunosuke\polyfill\enum\attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class EnumCase
{
    public function __construct(bool $enumCase = true) { }
}
