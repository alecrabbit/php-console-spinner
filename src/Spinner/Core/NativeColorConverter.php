<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IColorConverter;
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

    protected function hexToRgb(string $hex): array
    {
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $cLength = $length / 3;
        return [
            'r' => hexdec(substr($hex, 0, $cLength)),
            'g' => hexdec(substr($hex, $cLength, $cLength)),
            'b' => hexdec(substr($hex, $cLength * 2, $cLength)),
        ];
    }

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     */
    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator
    {
        foreach ($colors as $color) {
            if (null === $fromColor) {
                $fromColor = $color;
                continue;
            }
            yield from $this->gradient($fromColor, $color, $steps);
            $fromColor = $color;
        }
    }

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

    /**
     * @param array $colors Colors to generate gradients between
     * @param int $steps Steps between first and last color
     */
    protected function arrayGradients(array $colors, int $steps = 100): Generator
    {
        $count = count($colors);
        $steps = (int)floor($steps / ($count - 1));
        for ($i = 0; $i < $count - 1; $i++) {
            yield from $this->gradient($colors[$i], $colors[$i + 1], $steps);
        }
    }
}