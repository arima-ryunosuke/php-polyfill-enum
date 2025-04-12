PHP Enum Polyfill
====

## Description

This package emulates enum feature of php8.1 and later.

## Install

```json
{
    "require": {
        "ryunosuke/polyfill-enum": "*"
    }
}
```

## Demo

```sh
# Below are the same results
php80 demo/php80-polyfill.php
php81 demo/php81-builtin.php
```

## Spec

Inheriting a `*Enum` makes public const consider an enum case, and the case is obtained by a method call.
All other specifications are the same as native enum.

- `*Enum`
  - `PureEnum`: compatible native PureEnum (like `enum Hoge {...}`)
  - `IntBackedEnum`: compatible native IntBackedEnum (like `enum Fuga: int {...}`)
  - `StringBackedEnum`: compatible native StringBackedEnum (like `enum Piyo: string {...}`)

This package also provides `ReflectionEnum*`.
These are fully compatible with native.

- `ReflectionEnum*`
  - `ReflectionEnum`: [reflection Enum](https://www.php.net/manual/class.reflectionenum.php)
  - `ReflectionEnumUnitCase`: [reflection UnitCase](https://www.php.net/manual/class.reflectionenumunitcase.php)
  - `ReflectionEnumBackedCase`: [reflection BackedCase](https://www.php.net/manual/class.reflectionenumbackedcase.php)

## Usage

See demo for details

### enum

php8.1's enum is below

```php
enum Suit1
{
    use Magicable; // explain later

    const SIMPLE_CONST = null;

    private const OTHER_CONST = null;

    case Hearts;
    case Diamonds;
    case Clubs;
    case Spades;
}
var_dump(count(Suit1::cases())); // int(4)

enum Suit2: int
{
    use Magicable; // explain later

    const SIMPLE_CONST = 0;

    const OTHER_CONST = '';

    case Hearts   = 1;
    case Diamonds = 2;
    case Clubs    = 3;
    case Spades   = 4;
}
var_dump(count(Suit2::cases())); // int(4)

enum Suit3: string
{
    use Magicable; // explain later

    const SIMPLE_CONST = '';

    const OTHER_CONST = 0;

    case Hearts   = 'H';
    case Diamonds = 'D';
    case Clubs    = 'C';
    case Spades   = 'S';
}
var_dump(count(Suit3::cases())); // int(4)
```

This package's enum is below

```php
class Suit1 extends PureEnum
{
    #[EnumCase(false)]
    const SIMPLE_CONST = null; // This is not a case (because EnumCase attribute).

    private const OTHER_CONST = null; // This is not a case (because it is not public).

    const Hearts   = null;
    const Diamonds = null;
    const Clubs    = null;
    const Spades   = null;
}
var_dump(count(Suit1::cases())); // int(4)

class Suit2 extends IntBackedEnum
{
    #[EnumCase(false)]
    const SIMPLE_CONST = 0; // This is not a case (because EnumCase attribute).

    const OTHER_CONST = ''; // This is not a case (because it is not int).

    const Hearts   = 1;
    const Diamonds = 2;
    const Clubs    = 3;
    const Spades   = 4;
}
var_dump(count(Suit2::cases())); // int(4)

class Suit3 extends StringBackedEnum
{
    #[EnumCase(false)]
    const SIMPLE_CONST = ''; // This is not a case (because EnumCase attribute).

    const OTHER_CONST = 0; // This is not a case (because it is not string).

    const Hearts   = 'H';
    const Diamonds = 'D';
    const Clubs    = 'C';
    const Spades   = 'S';
}
var_dump(count(Suit3::cases())); // int(4)
```

enum case is const that ...

- public
- value matches backed type(Pure is null)
- not EnumCase(false)
  - notice: EnumCase(true) has no effect at currently

### mixin

Several traits are defined and can be conveniently used as needed.

- Methodable: provides Magic method call
    - `__callStatic`: returns case by name (e.g. `Suit::Hearts()`)
    - practically required for php < 8.1
- Compatible: provides compatibility php8.1's native enum
    - disable magic method(e.g. clone, sleep, etc)
    - assert like enum(e.g. final, no properties, etc)
    - do other
- Initializable: provides `initialize`
    - this can be used like a java static initializer

## Note

8.1 でポリフィルを使うと一部非互換となります。
具体的には enum_exists の結果が変わったり、 UnitEnum の instanceof が反応しなくなったりします。
これは組み込みゆえにどうしようもありません（組み込みの enum_exists にオレオレクラスを反応させることはできないし、UnitEnum の子クラスでもなくなるためです）。

そのための代替として `ryunosuke\ponyfill\enum` 名前空間にどちらにも使える enum_exists,instanceof が用意されています。
これを使っておけば native でも polyfill でも反応させることができます。
自分で管理できるコードならこっちを使っておけばよいでしょう。
ただし、依然として依存ライブラリなどで enum_exists,instanceof されている場合は本当にどうしようもありません。
uopz や runkit 等で組み込みの enum_exists を書き換えるしくらいしか方法はありません。

demo の中に

- 8.0 で polyfill を使うもの
- 8.1 で polyfill を使うもの
- 8.1 で builtin を使うもの

があるので出力結果を比較してみてください。

## FAQ

- Q. 8.1 のネイティブで良くない？
    - A. rhel9 の app stream に php8.0 が採用（10年サポート）されたため、8.0 縛りはしばらく続くと考えています（一応 7.4 も在命だしね）
- Q. だとして他に優秀なライブラリあるけど？
    - A. その通りです。ただ「enum が欲しい」のではなく「php8.1 の native enum 互換」が欲しかったのです（UnitEnum とか ReflectionEnum とか）
        - 例えば依存ライブラリで `instanceof UnitEnum` とか `new ReflectionEnum()` とかされていても問題なく使えるようになります
        - あと uopz の redefine で定数にオブジェクトを格納できると知ったのも大きいですね。これさえあれば使い勝手は 8.1 native とほぼ同じです 
- Q. 機能少ないけど？
    - A. ポリフィルに徹してます。変に便利機能を持たせると移行がしづらくなるためです
        - あくまで enum と似た機能を提供するに留め、いざ 8.1 に移行したときに最小限の変更で済むようにする、がコンセプトです（究極的には定義部だけの変更に留めたい）
        - 確かに __toString とか name => value な配列を返す方法とかがあると便利は便利なんですけどね…
    - A. …という考えでしたが、世のライブラリが使えないことがあるため、最低限のユーティリティを utility 名前空間で提供しています

## Release

Versioning follows semantic versioning.

- https://semver.org
  - major: change specifications (BC break)
  - minor: add feature (no BC break)
  - patch: fix bug (no BC break)

### 1.2.1

- [fixbug] from/tryFrom は strict type に従う

### 1.2.0

- [feature] php8.0/8.1 の両方で使える enum_exists/instanceof を用意
- [feature] utility を追加
- [fixbug] ネイティブの enum は var_export/eval でも同じインスタンスが返る

### 1.1.1

- [merge] 1.0.2

### 1.1.0

- [*change] php>=8.0

### 1.0.2

- [fixbug] trait/interface 読み込み時に多重定義エラーが出る不具合

### 1.0.1

- [fixbug] オートローダが無限ループする不具合を修正

### 1.0.0

- publish

## License

MIT
