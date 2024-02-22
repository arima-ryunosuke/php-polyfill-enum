<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\Test;

use enums;
use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ryunosuke\polyfill\enum\reflections\ReflectionEnumUnitCase;

class PHP81Test extends \ryunosuke\Test\AbstractTestCase
{
    function test()
    {
        if (version_compare(PHP_VERSION, 8.1) < 0) {
            $this->markTestSkipped();
        }
        require_once __DIR__ . '/files/php81.php';

        that(enums\PureEnum1::case)->isInstanceOf(enums\PureEnum1::class);
        that(enums\PureEnum2::case())->isInstanceOf(enums\PureEnum2::class);
        that((enums\PureEnum1::case)->name)->isSame(enums\PureEnum2::case()->name);

        that(enums\IntEnum1::case)->isInstanceOf(enums\IntEnum1::class);
        that(enums\IntEnum2::case())->isInstanceOf(enums\IntEnum2::class);
        that((enums\IntEnum1::case)->name)->isSame(enums\IntEnum2::case()->name);
        that((enums\IntEnum1::case)->value)->isSame(enums\IntEnum2::case()->value);

        that(enums\StringEnum1::case)->isInstanceOf(enums\StringEnum1::class);
        that(enums\StringEnum2::case())->isInstanceOf(enums\StringEnum2::class);
        that((enums\StringEnum1::case)->name)->isSame(enums\StringEnum2::case()->name);
        that((enums\StringEnum1::case)->value)->isSame(enums\StringEnum2::case()->value);

        $refenum1 = new ReflectionEnum(enums\PureEnum1::class);
        $refenum2 = new ReflectionEnum(enums\PureEnum2::class);
        that(array_map(fn($v) => $v->name, $refenum1->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->name, $refenum2->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->getValue(), $refenum1->getCases()))->isSame(enums\PureEnum1::cases());
        that(array_map(fn($v) => $v->getValue(), $refenum2->getCases()))->isSame(enums\PureEnum2::cases());
        that($refenum1->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum2->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum1->getCase('case')->getValue())->isInstanceOf(enums\PureEnum1::class);
        that($refenum2->getCase('case')->getValue())->isInstanceOf(enums\PureEnum2::class);

        $refenum1 = new ReflectionEnum(enums\IntEnum1::class);
        $refenum2 = new ReflectionEnum(enums\IntEnum2::class);
        that(array_map(fn($v) => $v->name, $refenum1->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->name, $refenum2->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->getValue(), $refenum1->getCases()))->isSame(enums\IntEnum1::cases());
        that(array_map(fn($v) => $v->getValue(), $refenum2->getCases()))->isSame(enums\IntEnum2::cases());
        that(array_map(fn($v) => $v->getBackingValue(), $refenum1->getCases()))->is([1]);
        that(array_map(fn($v) => $v->getBackingValue(), $refenum2->getCases()))->is([1]);
        that($refenum1->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum2->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum1->getCase('case')->getValue())->isInstanceOf(enums\IntEnum1::class);
        that($refenum2->getCase('case')->getValue())->isInstanceOf(enums\IntEnum2::class);

        $refenum1 = new ReflectionEnum(enums\StringEnum1::class);
        $refenum2 = new ReflectionEnum(enums\StringEnum2::class);
        that(array_map(fn($v) => $v->name, $refenum1->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->name, $refenum2->getCases()))->is(['case']);
        that(array_map(fn($v) => $v->getValue(), $refenum1->getCases()))->isSame(enums\StringEnum1::cases());
        that(array_map(fn($v) => $v->getValue(), $refenum2->getCases()))->isSame(enums\StringEnum2::cases());
        that(array_map(fn($v) => $v->getBackingValue(), $refenum1->getCases()))->is(['a']);
        that(array_map(fn($v) => $v->getBackingValue(), $refenum2->getCases()))->is(['a']);
        that($refenum1->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum2->getCase('case'))->isInstanceOf(ReflectionEnumUnitCase::class);
        that($refenum1->getCase('case')->getValue())->isInstanceOf(enums\StringEnum1::class);
        that($refenum2->getCase('case')->getValue())->isInstanceOf(enums\StringEnum2::class);
    }
}
