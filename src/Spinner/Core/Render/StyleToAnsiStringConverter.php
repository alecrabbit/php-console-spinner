<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;

use function count;

final class StyleToAnsiStringConverter implements IStyleToAnsiStringConverter
{
    private const SET = 'set';
    private const UNSET = 'unset';

    public function __construct(
        protected IAnsiColorParser $colorParser,
        protected IStyleOptionsParser $optionsParser,
    ) {
    }

    public function convert(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return $style->getFormat();
        }

        $fg = $this->fg($style);
        $bg = $this->bg($style);

        $options =
            $style->hasOptions()
                ? $this->optionsParser->parseOptions($style->getOptions())
                : [];

        return
            $this->set($fg, $bg, $options) . $style->getFormat() . $this->unset($fg, $bg, $options);
    }

    protected function fg(IStyle $style): string
    {
        $parsed = $this->colorParser->parseColor((string)$style->getFgColor());
        return '' === $parsed ? '' : '3' . $parsed;
    }

    protected function bg(IStyle $style): string
    {
        $parsed = $this->colorParser->parseColor((string)$style->getBgColor());
        return '' === $parsed ? '' : '4' . $parsed;
    }

    protected function set(string $fg, string $bg, iterable $options = []): string
    {
        $codes = [];
        if ('' !== $fg) {
            $codes[] = $fg;
        }
        if ('' !== $bg) {
            $codes[] = $bg;
        }
        foreach ($options as $option) {
            $codes[] = $option[self::SET];
        }
        if (0 === count($codes)) {
            return '';
        }

        return $this->unwrap($codes);
    }

    protected function unwrap(array $setCodes): string
    {
        return sprintf("\033[%sm", implode(';', array_unique($setCodes)));
    }

    public function unset(string $fg, string $bg, iterable $options = []): string
    {
        $codes = [];
        if ('' !== $fg) {
            $codes[] = 39;
        }
        if ('' !== $bg) {
            $codes[] = 49;
        }
        foreach ($options as $option) {
            $codes[] = $option[self::UNSET];
        }
        if (0 === count($codes)) {
            return '';
        }

        return $this->unwrap($codes);
    }
}
