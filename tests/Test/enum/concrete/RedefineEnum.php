<?php
namespace ryunosuke\Test\enum\concrete;

use ryunosuke\polyfill\enum\IntBackedEnum;
use ryunosuke\polyfill\enum\traits\Compatible;
use ryunosuke\polyfill\enum\traits\Initializable;

/**
 * @method static self A()
 * @method static self B()
 * @method static self C()
 */
final class RedefineEnum extends IntBackedEnum
{
    use Compatible;
    use Initializable;

    const A = 1;
    const B = 2;
    const C = 3;
}
