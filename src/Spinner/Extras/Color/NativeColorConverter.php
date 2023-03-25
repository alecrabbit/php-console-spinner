<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Color\HSLColorDTO;
use AlecRabbit\Spinner\Contract\Color\IColorDTO;
use AlecRabbit\Spinner\Contract\Color\RGBColorDTO;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IColorConverter;
use AlecRabbit\Spinner\Helper\Asserter;
use Generator;
use Traversable;

final class NativeColorConverter implements IColorConverter
{
    public function hslToRgb(int $hue, float $s = 1.0, float $l = 0.5): RGBColorDTO
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

        return new RGBColorDTO((int)$r, (int)$g, (int)$b);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function rgbToHsl(string $color): HSLColorDTO
    {
        $rgb = $this->hexToRgb($color);

        $r = $rgb->red / 255;
        $g = $rgb->green / 255;
        $b = $rgb->blue / 255;

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

        return new HSLColorDTO((int)round($h * 360), $s, $l);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function hexToRgb(string $hex): RGBColorDTO
    {
        Asserter::assertHexStringColor($hex);

        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $cLength = (int)($length / 3);
        return
            new RGBColorDTO(
                hexdec(substr($hex, 0, $cLength)),
                hexdec(substr($hex, $cLength, $cLength)),
                hexdec(substr($hex, $cLength * 2, $cLength)),
            );
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
    protected function gradient(string|IColorDTO $from, string|IColorDTO $to, int $steps = 100): Generator
    {
        $f = $this->refineRGB($from);
        $t = $this->refineRGB($to);

        $rStep = ($t->red - $f->red) / $steps;
        $gStep = ($t->green - $f->green) / $steps;
        $bStep = ($t->blue - $f->blue) / $steps;

        for ($i = 0; $i < $steps; $i++) {
            $r = (int)round($f->red + $rStep * $i);
            $g = (int)round($f->green + $gStep * $i);
            $b = (int)round($f->blue + $bStep * $i);

            yield (new RGBColorDTO($r, $g, $b))->__toString();
        }
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

    /**
     * @throws InvalidArgumentException
     */
    protected function refineRGB(IColorDTO|string $from): RGBColorDTO
    {
        if ($from instanceof RGBColorDTO) {
            return $from;
        }

        if ($from instanceof HSLColorDTO) {
            return $this->hslToRgb($from->hue, $from->saturation, $from->lightness);
        }

        return $this->hexToRgb($from);
    }
}