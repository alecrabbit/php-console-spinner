<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\A\AColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class ColorToAnsiCodeConverter extends AColorToAnsiCodeConverter implements IColorToAnsiCodeConverter
{
    /** @inheritdoc */
    public function ansiCode(string $color): string
    {
        $color = $this->normalize($color);

        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => $this->convert4($color),
                OptionStyleMode::ANSI24 => $this->convertFromHexToAnsiColorCode($color),
                default => $this->convert8($color),
            };
    }

    protected function convert4(string $color): string
    {
        $index = Ansi4Color::getIndex($color);

        if ($index) {
            return (string)$index;
        }

        return $this->convertFromHexToAnsiColorCode($color);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromHexToAnsiColorCode(string $hexColor): string
    {
        $color = $this->toInt($hexColor);

        $r = ($color >> 16) & 255;
        $g = ($color >> 8) & 255;
        $b = $color & 255;

        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => (string)$this->convertFromRGB($r, $g, $b),
                OptionStyleMode::ANSI8 => '8;5;' . ((string)$this->convertFromRGB($r, $g, $b)),
                OptionStyleMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
                default => throw new InvalidArgumentException('Should not be thrown: Unsupported style mode.'),
            };
    }

    protected function toInt(string $color): int
    {
        return (int)hexdec(str_replace('#', '', $color));
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromRGB(int $r, int $g, int $b): int
    {
        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
                OptionStyleMode::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
                default => throw new InvalidArgumentException(
                    sprintf(
                        'RGB cannot be converted to "%s".',
                        $this->styleMode->name
                    )
                )
            };
    }

    protected function degradeHexColorToAnsi4(int $r, int $g, int $b): int
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if (0 === round($this->getSaturation($r, $g, $b) / 50)) { // 0 === round(... - it is a hack
            return 0;
        }

        return (int)((round($b / 255) << 2) | (round($g / 255) << 1) | round($r / 255));
    }

    protected function getSaturation(int $r, int $g, int $b): int
    {
        $rf = $r / 255;
        $gf = $g / 255;
        $bf = $b / 255;
        $v = max($rf, $gf, $bf);

        if (0 === $diff = $v - min($rf, $gf, $bf)) {
            return 0;
        }

        return (int)($diff * 100 / $v);
    }

    /**
     * Inspired from (MIT license):
     * @link https://github.com/ajalt/colormath/blob/e464e0da1b014976736cf97250063248fc77b8e7/colormath/src/commonMain/kotlin/com/github/ajalt/colormath/model/Ansi256.kt
     */
    protected function degradeHexColorToAnsi8(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            return $this->degradeFrom($r);
        }

        return 16 +
            (36 * (int)round($r / 255 * 5)) +
            (6 * (int)round($g / 255 * 5)) +
            (int)round($b / 255 * 5);
    }

    protected function degradeFrom(int $r): int
    {
        if ($r < 8) {
            return 16;
        }

        if ($r > 248) {
            return 231;
        }

        return (int)round(($r - 8) / 247 * 24) + 232;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert8(string $color): string
    {
        $index = Ansi8Color::getIndex($color);

        if ($index) {
            return '8;5;' . $index;
        }

        return $this->convertFromHexToAnsiColorCode($color);
    }
}
