<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Color\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Core\Color\Ansi8Color;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Mixin\AnsiColorTableTrait;

abstract class AAnsiStyleConverter implements IAnsiStyleConverter
{
    use AnsiColorTableTrait;

    public function __construct(
        protected StyleMode $styleMode,
    ) {
    }

    /** @inheritdoc */
    public function ansiCode(int|string $color, StyleMode $styleMode): string
    {
        $styleMode = $styleMode->lowest($this->styleMode);

        $this->assertColor($color, $styleMode);

        $color24 = (string)$color;

        return match ($styleMode) {
            StyleMode::ANSI4 => $this->convert4($color, $styleMode),
            StyleMode::ANSI8 => $this->convert8($color, $styleMode),
            StyleMode::ANSI24 => $this->convert24($color24, $styleMode),
            default => throw new LogicException(
                sprintf(
                    '%s::%s: Unable to convert "%s" to ansi code.',
                    StyleMode::class,
                    $styleMode->name,
                    $color
                )
            ),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertColor(int|string $color, StyleMode $styleMode): void
    {
        match (true) {
            is_int($color) => Asserter::assertIntColor($color, $styleMode),
            is_string($color) => Asserter::assertHexStringColor($color),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert4(int|string $color, StyleMode $styleMode): string
    {
        if (is_int($color)) {
            return (string)$color;
        }
        return $this->convertFromHexToAnsiColorCode($color, $styleMode);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromHexToAnsiColorCode(string $hexColor, StyleMode $styleMode): string
    {
        $hexColor = str_replace('#', '', $hexColor);

        if (3 === strlen($hexColor)) {
            $hexColor = $hexColor[0] . $hexColor[0] . $hexColor[1] . $hexColor[1] . $hexColor[2] . $hexColor[2];
        }

        if (6 !== strlen($hexColor)) {
            throw new InvalidArgumentException(sprintf('Invalid "#%s" color.', $hexColor));
        }

        $color = hexdec($hexColor);

        $r = ($color >> 16) & 255;
        $g = ($color >> 8) & 255;
        $b = $color & 255;

        return match ($styleMode) {
            StyleMode::ANSI4 => (string)$this->convertFromRGB($r, $g, $b, $styleMode),
            StyleMode::ANSI8 => '8;5;' . ((string)$this->convertFromRGB($r, $g, $b, $styleMode)),
            StyleMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
            StyleMode::NONE => throw new InvalidArgumentException(
                sprintf(
                    'Hex color cannot be converted to %s.',
                    $styleMode->name
                )
            ),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromRGB(int $r, int $g, int $b, StyleMode $styleMode): int
    {
        return match ($styleMode) {
            StyleMode::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
            StyleMode::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
            default => throw new InvalidArgumentException(
                sprintf(
                    'RGB cannot be converted to %s.',
                    $styleMode->name
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
     * Inspired from https://github.com/ajalt/colormath/blob/e464e0da1b014976736cf97250063248fc77b8e7/colormath/src/commonMain/kotlin/com/github/ajalt/colormath/model/Ansi256.kt code (MIT license).
     */
    protected function degradeHexColorToAnsi8(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            if ($r < 8) {
                return 16;
            }

            if ($r > 248) {
                return 231;
            }

            return (int)round(($r - 8) / 247 * 24) + 232;
        }

        return 16 +
            (36 * (int)round($r / 255 * 5)) +
            (6 * (int)round($g / 255 * 5)) +
            (int)round($b / 255 * 5);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert8(int|string $color, StyleMode $styleMode): string
    {
        if (is_int($color)) {
            return '8;5;' . $color;
        }

        $index = Ansi8Color::getIndex($color);

        if ($index) {
            return '8;5;' . $index;
        }

        return $this->convertFromHexToAnsiColorCode($color, $styleMode);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert24(string $color, StyleMode $styleMode): string
    {
        return $this->convertFromHexToAnsiColorCode($color, $styleMode);
    }

    public function isDisabled(): bool
    {
        return !$this->styleMode->isStylingEnabled();
    }
}