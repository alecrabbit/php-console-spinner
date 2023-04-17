<?php

declare(strict_types=1);

// 23.03.23
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
    /** @inheritdoc */
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

        return new HSLColor((int)round($h * 360), $s, $l, $rgb->alpha);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function refineRGB(string|IColor $color): RGBColor
    {
        if ($color instanceof RGBColor) {
            return $color;
        }

        if ($color instanceof HSLColor) {
            return $this->toRGB($color);
        }
        /** @var string $color */
        return RGBColor::fromHex($color);
    }

    /** @inheritdoc */
    public function toRGB(string|IColor $color): RGBColor
    {
        if ($color instanceof RGBColor) {
            return $color;
        }
        if (is_string($color)) {
            return RGBColor::fromHex($color);
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

        return
            new RGBColor(
                (int)(($r + $m) * 255),
                (int)(($g + $m) * 255),
                (int)(($b + $m) * 255),
                $color->alpha
            );
    }

    /** @inheritdoc */
    public function gradients(Traversable $colors, int $steps = 10, null|string|IColor $fromColor = null): Generator
    {
        /** @var string|IColor $color */
        foreach ($colors as $color) {
            self::assertColor($color);
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
    protected static function assertColor(mixed $color): void
    {
        if (is_string($color)) {
            Asserter::assertHexStringColor($color);
            return;
        }

        if (is_object($color)) {
            Asserter::assertIsSubClass($color, IColor::class);
            return;
        }

        throw new InvalidArgumentException(
            sprintf('Invalid color type: %s.', Stringify::value($color))
        );
    }

    /** @inheritdoc */
    public function gradient(string|IColor $from, string|IColor $to, int $steps = 100): Generator
    {
        $from = $this->refineRGB($from);
        $to = $this->refineRGB($to);

        $rStep = ($to->red - $from->red) / $steps;
        $gStep = ($to->green - $from->green) / $steps;
        $bStep = ($to->blue - $from->blue) / $steps;

        for ($i = 0; $i < $steps; $i++) {
            yield new RGBColor(
                (int)round($from->red + $rStep * $i),
                (int)round($from->green + $gStep * $i),
                (int)round($from->blue + $bStep * $i),
            );
        }
    }
}
