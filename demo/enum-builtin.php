<?php

namespace demo;

use ryunosuke\polyfill\enum\traits\Initializable;
use ryunosuke\polyfill\enum\traits\Methodable;

/**
 * @method static self Easy()
 * @method static self Normal()
 * @method static self Hard()
 */
enum Level: string
{
    use Methodable;
    use Initializable;

    case Easy   = 'easy';
    case Normal = 'normal';
    case Hard   = 'hard';
}
