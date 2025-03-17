<?php
namespace ryunosuke\utility\enum\attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Label
{
    public function __construct(string $label) { }
}
