<?php

namespace demo;

use ryunosuke\polyfill\enum\StringBackedEnum;
use ryunosuke\polyfill\enum\traits\Compatible;
use ryunosuke\polyfill\enum\traits\Initializable;

/**
 * @method static self Easy()
 * @method static self Normal()
 * @method static self Hard()
 */
final class Level extends StringBackedEnum
{
    use Compatible;
    use Initializable;

    const Easy   = 'easy';
    const Normal = 'normal';
    const Hard   = 'hard';
}
