<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Contract\IColorConverter;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use Generator;
use Traversable;

final class NativeColorConverter implements IColorConverter
{
    public function hslToRgb(int $hue, float $s = 1.0, float $l = 0.5): string
    {
        $h = $hue / 360;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $l - $c / 2;

        $r = 0;
        $g = 0;
        $b = 0;

        match (true) {
            $h < 1 / 6 => [$r, $g] = [$c, $x],
            $h < 2 / 6 => [$r, $g] = [$x, $c],
            $h < 3 / 6 => [$g, $b] = [$c, $x],
            $h < 4 / 6 => [$g, $b] = [$x, $c],
            $h < 5 / 6 => [$r, $b] = [$x, $c],
            default => [$r, $b] = [$c, $x],
        };

        $r = ($r + $m) * 255;
        $g = ($g + $m) * 255;
        $b = ($b + $m) * 255;

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function rgbToHsl(string $color): array
    {
        $rgb = $this->hexToRgb($color);

        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;

        if ($max !== $min) {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r:
                    $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                    break;
                case $g:
                    $h = ($b - $r) / $d + 2;
                    break;
                case $b:
                    $h = ($r - $g) / $d + 4;
                    break;
            }

            $h /= 6;
        }

        return [
            'h' => (int)round($h * 360),
            's' => (int)round($s * 100),
            'l' => (int)round($l * 100),
        ];
    }

    /**
     * @return array<string, int>
     * @throws InvalidArgumentException
     */
    protected function hexToRgb(string $hex): array
    {
        $this->assertStringColor($hex);

        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $cLength = (int)($length / 3);
        return [
            'r' => hexdec(substr($hex, 0, $cLength)),
            'g' => hexdec(substr($hex, $cLength, $cLength)),
            'b' => hexdec(substr($hex, $cLength * 2, $cLength)),
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertStringColor(string $entry): void
    {
        $strlen = strlen($entry);
        match (true) {
            0 === $strlen => throw new InvalidArgumentException(
                'Value should not be empty string.'
            ),
            !str_starts_with($entry, '#') => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. No "#" found.',
                    $entry
                )
            ),
            4 !== $strlen && 7 !== $strlen => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. Length: %d.',
                    $entry,
                    $strlen
                )
            ),
            default => null,
        };
    }

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     * @throws InvalidArgumentException
     */
    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator
    {
        /** @var string $color */
        foreach ($colors as $color) {
            if (null === $fromColor) {
                $fromColor = $color;
                continue;
            }
            yield from $this->gradient($fromColor, $color, $steps);
            $fromColor = $color;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function gradient(string $from, string $to, int $steps = 100): Generator
    {
        $f = $this->hexToRgb($from);
        $t = $this->hexToRgb($to);

        $rStep = ($t['r'] - $f['r']) / $steps;
        $gStep = ($t['g'] - $f['g']) / $steps;
        $bStep = ($t['b'] - $f['b']) / $steps;

        for ($i = 0; $i < $steps; $i++) {
            $r = (int)round($f['r'] + $rStep * $i);
            $g = (int)round($f['g'] + $gStep * $i);
            $b = (int)round($f['b'] + $bStep * $i);

            yield $this->rgbToHex($r, $g, $b);
        }
    }

    protected function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    /** @inheritdoc */
    public function ansiCode(IStyle|int|string $color, ColorMode $colorMode): string
    {
        if ($color instanceof IStyle) {
            throw new DomainException(
                sprintf('%s is not supported by this color converter', IStyle::class)
            );
        }

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
            is_int($color) => $this->assertIntColor($color, $colorMode),
            is_string($color) => $this->assertStringColor($color),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertIntColor(int $color, ColorMode $colorMode): void
    {
        match (true) {
            0 > $color => throw new InvalidArgumentException(
                sprintf(
                    'Value should be positive integer, %d given.',
                    $color
                )
            ),
            ColorMode::ANSI24->name === $colorMode->name => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode rendering from int is not allowed.',
                    ColorMode::class,
                    ColorMode::ANSI24->name
                )
            ),
            ColorMode::ANSI8->name === $colorMode->name && 255 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..255, %d given.',
                    ColorMode::class,
                    ColorMode::ANSI8->name,
                    $color
                )
            ),
            ColorMode::ANSI4->name === $colorMode->name && 16 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..15, %d given.',
                    ColorMode::class,
                    ColorMode::ANSI4->name,
                    $color
                )
            ),
            default => null,
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
    private function convertFromHexToAnsiColorCode(string $hexColor, ColorMode $colorMode): string
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
            ColorMode::NONE => throw new InvalidArgumentException('Hex color cannot be converted to NONE.'),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    private function convertFromRGB(int $r, int $g, int $b, ColorMode $colorMode): int
    {
        return match ($colorMode) {
            ColorMode::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
            ColorMode::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
            default => throw new InvalidArgumentException("RGB cannot be converted to $colorMode->name.")
        };
    }

    private function degradeHexColorToAnsi4(int $r, int $g, int $b): int
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
    private function degradeHexColorToAnsi8(int $r, int $g, int $b): int
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

    /**
     * @param array $colors Colors to generate gradients between
     * @param int $steps Steps between first and last color
     * @throws InvalidArgumentException
     */
    protected function arrayGradients(array $colors, int $steps = 100): Generator
    {
        $count = count($colors);
        $steps = (int)floor($steps / ($count - 1));
        for ($i = 0; $i < $count - 1; $i++) {
            yield from $this->gradient((string)$colors[$i], (string)$colors[$i + 1], $steps);
        }
    }
}