<?php
/**
 * @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection
 */
namespace demo;

use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use stdClass;

function var_export($statement)
{
    static $lines = null;
    $lines ??= file(__FILE__, FILE_IGNORE_NEW_LINES);

    $statement = is_object($statement) ? get_class($statement) : \var_export($statement, true);
    echo $lines[debug_backtrace()[0]['line'] - 1], " $statement\n";
}

Level::__autoload();

echo "# enum_exists\n";

var_export(enum_exists(Level::class));    //
var_export(enum_exists(stdClass::class)); //

echo "\n# factory method\n";

var_export($normal1 = Level::Normal());             //
var_export($normal2 = Level::from('normal'));       //
var_export($normal3 = Level::tryFrom('undefined')); //

echo "\n# same instance\n";

var_export($normal1 === $normal2); //
var_export($normal3 === null);     //

echo "\n# if uopz installed\n";

var_export(Level::Normal === Level::Normal()); //

echo "\n# instanceof\n";

var_export($normal1 instanceof \UnitEnum);   //
var_export($normal1 instanceof \BackedEnum); //

echo "\n# name/value\n";

var_export($normal1->name);  //
var_export($normal2->value); //

echo "\n# emulate ReflectionEnum\n";

var_export($refenum = new ReflectionEnum($normal1)); //
var_export($refenum->isBacked());                    //
var_export($refenum->hasCase('Normal'));             //
var_export($refenum->hasCase('undefined'));          //
var_export($refenum->getBackingType()->getName());   //

echo "\n# emulate ReflectionEnumBackCase\n";

var_export($refcase = $refenum->getCase('Normal')); //
var_export($refcase->getValue() === $normal1);      //
var_export($refcase->getBackingValue());            //
