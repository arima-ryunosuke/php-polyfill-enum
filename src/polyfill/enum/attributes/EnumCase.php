<?php
namespace ryunosuke\polyfill\enum\attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class EnumCase extends AbstractAttribute
{
    public function __construct($enumCase = true) { }
}
