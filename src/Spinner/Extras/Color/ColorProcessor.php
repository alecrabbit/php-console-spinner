<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;

use function abs;
use function fmod;
use function is_string;
use function max;
use function min;
use function round;

final class ColorProcessor implements IColorProcessor
{
    private const FLOAT_PRECISION = 2;

    public function __construct(
        protected int $floatPrecision = self::FLOAT_PRECISION,
    ) {
    }


    public function toHSL(string|IColor $color): HSLColor
    {
        if (is_string($color)) {
            $color = $this->colorFromString($color);
        }

        if ($color instanceof HSLColor) {
            return $color;
        }

        /** @var RGBColor $color */
        $r = $color->red / 255;
        $g = $color->green / 255;
        $b = $color->blue / 255;

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

        return
            new HSLColor(
                (int)round($h * 360),
                round($s, $this->floatPrecision),
                round($l, $this->floatPrecision),
                $color->alpha
            );
    }

    public function colorFromString(string $color): IColor
    {
        $pattern = '/^hsla?\((\d+),\s*(\d+)%,\s*(\d+)%(?:,\s*([\d.]+))?\)$/';
        if (preg_match($pattern, $color, $matches)) {
            $h = (int)$matches[1];
            $s = (float)$matches[2] / 100;
            $l = (float)$matches[3] / 100;
            $a = isset($matches[4]) ? (float)$matches[4] : 1.0;
            return
                new HSLColor($h, $s, $l, $a);
        }

        return RGBColor::fromString($color);
    }

    public function toRGB(string|IColor $color): RGBColor
    {
        if (is_string($color)) {
            $color = $this->colorFromString($color);
        }

        if ($color instanceof RGBColor) {
            return $color;
        }

        /** @var HSLColor $color */
        $hue = $color->hue;
        $saturation = $color->saturation;
        $lightness = $color->lightness;

        $h = $hue / 360;
        $c = (1 - abs(2 * $lightness - 1)) * $saturation;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $lightness - $c / 2;

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

        return new RGBColor(
            (int)round(($r + $m) * 255),
            (int)round(($g + $m) * 255),
            (int)round(($b + $m) * 255),
            $color->alpha
        );
    }

    public function getFloatPrecision(): int
    {
        return $this->floatPrecision;
    }
}
