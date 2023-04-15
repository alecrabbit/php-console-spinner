<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Color\Style\IStyleOptions;
use AlecRabbit\Spinner\Contract\Color\Style\StyleOption;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use function count;

final class StyleToAnsiStringConverter implements IStyleToAnsiStringConverter
{
    private const SET = 'set';
    private const UNSET = 'unset';

    public function __construct(
        protected IHexColorToAnsiCodeConverter $converter,
    ) {
    }

    public function convert(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return $style->getFormat();
        }

        $fg = $this->parse((string)$style->getFgColor());
        $bg = $this->parse((string)$style->getBgColor(), true);

        $options = $style->hasOptions() ? $this->parseOptions($style->getOptions()) : [];

        return
            $this->set($fg, $bg, $options) . $style->getFormat() . $this->unset($fg, $bg, $options);
    }

    protected function parse(string $color, bool $bg = false): string
    {
        if ('' === $color) {
            return '';
        }

        if ('#' === $color[0]) {
            return ($bg ? '4' : '3') . $this->converter->ansiCode($color);
        }

        throw new InvalidArgumentException('Invalid color format: ' . $color);
    }

    protected function parseOptions(?IStyleOptions $styleOptions): iterable
    {
        $optionCodes = [];
        if ($styleOptions) {
            foreach ($styleOptions as $option) {
                $optionCodes[] = self::getOptionCodes($option);
            }
        }
        return $optionCodes;
    }

    protected static function getOptionCodes(StyleOption $option): array
    {
        return match ($option) {
            StyleOption::BOLD => [self::SET => 1, self::UNSET => 22],
            StyleOption::DIM => [self::SET => 2, self::UNSET => 22],
            StyleOption::ITALIC => [self::SET => 3, self::UNSET => 23],
            StyleOption::UNDERLINE => [self::SET => 4, self::UNSET => 24],
            StyleOption::BLINK => [self::SET => 5, self::UNSET => 25],
            StyleOption::REVERSE => [self::SET => 7, self::UNSET => 27],
            StyleOption::HIDDEN => [self::SET => 8, self::UNSET => 28],
            StyleOption::STRIKETHROUGH => [self::SET => 9, self::UNSET => 29],
            StyleOption::DOUBLE_UNDERLINE => [self::SET => 21, self::UNSET => 24],
            default => throw new InvalidArgumentException('Unknown option: ' . $option->name),
        };
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

        return $this->toAnsiString($codes);
    }

    protected function toAnsiString(array $setCodes): string
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

        return $this->toAnsiString($codes);
    }
}
