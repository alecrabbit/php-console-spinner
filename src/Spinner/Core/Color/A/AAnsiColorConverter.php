<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Color\A;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class AAnsiColorConverter implements IAnsiColorConverter
{
    public function __construct(
        protected ColorMode $colorMode,
    ) {
    }

    /** @inheritdoc */
    public function ansiCode(IStyle|int|string $color, ColorMode $colorMode): string
    {
        if ($color instanceof IStyle) {
            throw new DomainException(
                sprintf('%s is not supported by this color converter', IStyle::class)
            );
        }

        $colorMode = $colorMode->lowest($this->colorMode);

        $this->assertColor($color, $colorMode);

        $color24 = (string)$color;

        return match ($colorMode) {
            ColorMode::ANSI4 => $this->convert4($color, $colorMode),
            ColorMode::ANSI8 => $this->convert8($color, $colorMode),
            ColorMode::ANSI24 => $this->convert24($color24, $colorMode),
            default => throw new LogicException(
                sprintf(
                    '%s::%s: Unable to convert "%s" to ansi code.',
                    ColorMode::class,
                    $colorMode->name,
                    $color
                )
            ),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertColor(IStyle|int|string $color, ColorMode $colorMode): void
    {
        match (true) {
            is_int($color) => Asserter::assertIntColor($color, $colorMode),
            is_string($color) => Asserter::assertHexStringColor($color),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert4(int|string $color, ColorMode $colorMode): string
    {
        if (is_int($color)) {
            return (string)$color;
        }
        return $this->convertFromHexToAnsiColorCode($color, $colorMode);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromHexToAnsiColorCode(string $hexColor, ColorMode $colorMode): string
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

        return match ($colorMode) {
            ColorMode::ANSI4 => (string)$this->convertFromRGB($r, $g, $b, $colorMode),
            ColorMode::ANSI8 => '8;5;' . ((string)$this->convertFromRGB($r, $g, $b, $colorMode)),
            ColorMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
            ColorMode::NONE => throw new InvalidArgumentException(
                sprintf(
                    'Hex color cannot be converted to %s.',
                    $colorMode->name
                )
            ),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromRGB(int $r, int $g, int $b, ColorMode $colorMode): int
    {
        return match ($colorMode) {
            ColorMode::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
            ColorMode::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
            default => throw new InvalidArgumentException(
                sprintf(
                    'RGB cannot be converted to %s.',
                    $colorMode->name
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
    protected function convert8(int|string $color, ColorMode $colorMode): string
    {
        if (is_int($color)) {
            return '8;5;' . $color;
        }

        /** @var null|array<int, string> $colors8 */
        static $colors8 = null;

        if (null === $colors8) {
            $colors8 = array_slice(IAnsiColorConverter::COLOR_TABLE, 16, preserve_keys: true);
        }

        /** @var int|false $result */
        $result =
            // non-optimal code, but it's not a bottleneck
            array_search(
                $color,
                $colors8,
                true
            );


        if (false === $result) {
            return $this->convertFromHexToAnsiColorCode($color, $colorMode);
        }

        return '8;5;' . (string)$result;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert24(string $color, ColorMode $colorMode): string
    {
        return $this->convertFromHexToAnsiColorCode($color, $colorMode);
    }

    public function isEnabled(): bool
    {
        return $this->colorMode->isColorEnabled();
    }
}