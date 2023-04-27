<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\HSLColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Helper\Stringify;
use Generator;
use Traversable;

use function abs;
use function fmod;
use function is_object;
use function is_string;
use function max;
use function min;
use function round;
use function sprintf;

final class ColorProcessor implements IColorProcessor
{
    private const FLOAT_PRECISION = 2;

    public function __construct(
        protected int $floatPrecision = self::FLOAT_PRECISION,
    ) {
    }


    public function toHSL(string|IColor $color): HSLColor
    {
        if ($color instanceof HSLColor) {
            return $color;
        }

        $rgb = $this->refineRGB($color);

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

        return
            new HSLColor(
                (int)round($h * 360),
                round($s, $this->floatPrecision),
                round($l, $this->floatPrecision),
                $rgb->alpha
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function refineRGB(string|IColor $color): RGBColor
    {
        if (is_string($color)) {
            $color = $this->colorFromString($color);
        }

        if ($color instanceof HSLColor) {
            return $this->toRGB($color);
        }

        if ($color instanceof RGBColor) {
            return $color;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unsupported implementation of "%s" given: "%s".',
                IColor::class,
                get_debug_type($color)
            )
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

        $pattern = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';
        if (preg_match($pattern, $color, $matches)) {
            $r = (int)$matches[1];
            $g = (int)$matches[2];
            $b = (int)$matches[3];
            $a = isset($matches[4]) ? (float)$matches[4] : 1.0;
            return new RGBColor($r, $g, $b, $a);
        }

        return RGBColor::fromHex($color);
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

//    public function gradients(Traversable $colors, int $steps = 10, null|string|IColor $fromColor = null): Generator
//    {
//        /** @var string|IColor $color */
//        foreach ($colors as $color) {
//            self::assertColor($color);
//            if ($fromColor === null) {
//                $fromColor = $color;
//                continue;
//            }
//            yield from $this->gradient($fromColor, $color, $steps);
//            $fromColor = $color;
//        }
//    }

//    /**
//     * @throws InvalidArgumentException
//     */
//    private static function assertColor(mixed $color): void
//    {
//        if (is_string($color)) {
//            Asserter::assertHexStringColor($color);
//            return;
//        }
//
//        if (is_object($color)) {
//            Asserter::assertIsSubClass($color, IColor::class);
//            return;
//        }
//
//        throw new InvalidArgumentException(
//            sprintf('Invalid color type: %s.', Stringify::value($color))
//        );
//    }

//    public function gradient(string|IColor $from, string|IColor $to, int $steps = 100): Generator
//    {
//        $from = $this->refineRGB($from);
//        $to = $this->refineRGB($to);
//
//        $rStep = ($to->red - $from->red) / $steps;
//        $gStep = ($to->green - $from->green) / $steps;
//        $bStep = ($to->blue - $from->blue) / $steps;
//
//        for ($i = 0; $i < $steps; $i++) {
//            yield new RGBColor(
//                (int)round($from->red + $rStep * $i),
//                (int)round($from->green + $gStep * $i),
//                (int)round($from->blue + $bStep * $i),
//            );
//        }
//    }

    public function getFloatPrecision(): int
    {
        return $this->floatPrecision;
    }
}
