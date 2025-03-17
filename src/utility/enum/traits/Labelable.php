<?php
namespace ryunosuke\utility\enum\traits;

use ryunosuke\polyfill\enum\reflections\ReflectionEnum;
use ryunosuke\utility\enum\attributes\Label;

trait Labelable
{
    /**
     * alternative Label attribute for expression
     *
     * php can not use expression attribute context.
     *
     * @codeCoverageIgnore
     */
    public function label(): ?string
    {
        return null;
    }

    /**
     * get [label, ...]
     *
     * @return array<string>
     */
    public static function labels(): array
    {
        return array_column(static::___labels(), 'label');
    }

    /**
     * get [name => label, ...]
     *
     * @return array{string: string}
     */
    public static function nameLabels(): array
    {
        return array_column(static::___labels(), 'label', 'name');
    }

    /**
     * get [value => label, ...]
     *
     * @return array{int|string: string}
     */
    public static function valueLabels(): array
    {
        return array_column(static::___labels(), 'label', 'value');
    }

    private static function ___labels(): array
    {
        return array_values(
            array_filter(
                array_map(fn(self $case) => [
                    'name'  => $case->name,
                    'value' => $case->value ?? null,
                    'label' => $case->___label(),
                ], static::cases()),
                fn($v) => $v['label'] !== null
            ),
        );
    }

    private function ___label(): ?string
    {
        $label = $this->label();
        if ($label !== null) {
            return $label;
        }

        $refenum = new ReflectionEnum($this);
        $refcase = $refenum->getCase($this->name);

        $attribute = $refcase->getAttributes(Label::class);
        if (isset($attribute[0])) {
            return $attribute[0]->getArguments()[0];
        }

        return null;
    }
}
