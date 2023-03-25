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
use AlecRabbit\Spinner\Helper\Value;
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

final class NativeColorConverter implements IColorConverter
{
    /**
     * @throws InvalidArgumentException
     */
    public function rgbToHsl(string|IColorDTO $color): HSLColorDTO
    {
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

        return new HSLColorDTO((int)round($h * 360), $s, $l, $rgb->alpha);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function refineRGB(string|IColorDTO $color): RGBColorDTO
    {
        if ($color instanceof RGBColorDTO) {
            return $color;
        }

        if ($color instanceof HSLColorDTO) {
            return $this->hslToRgb($color->hue, $color->saturation, $color->lightness);
        }

        return RGBColorDTO::fromHex($color);
    }

    public function hslToRgb(int $hue, float $s = 1.0, float $l = 0.5, float $alpha = 1.0): RGBColorDTO
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

        return
            new RGBColorDTO(
                (int)($r + $m) * 255,
                (int)($g + $m) * 255,
                (int)($b + $m) * 255,
                $alpha
            );
    }

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     * @throws InvalidArgumentException
     */
    public function gradients(Traversable $colors, int $steps = 10, null|string|IColorDTO $fromColor = null): Generator
    {
        /** @var string|IColorDTO $color */
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
            Asserter::isSubClass($color, IColorDTO::class);
            return;
        }

        throw new InvalidArgumentException(
            sprintf('Invalid color type: %s.', Value::stringify($color))
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function gradient(string|IColorDTO $from, string|IColorDTO $to, int $steps = 100): Generator
    {
        $from = $this->refineRGB($from);
        $to = $this->refineRGB($to);

        $rStep = ($to->red - $from->red) / $steps;
        $gStep = ($to->green - $from->green) / $steps;
        $bStep = ($to->blue - $from->blue) / $steps;

        for ($i = 0; $i < $steps; $i++) {
            $dto =
                new RGBColorDTO(
                    (int)round($from->red + $rStep * $i),
                    (int)round($from->green + $gStep * $i),
                    (int)round($from->blue + $bStep * $i),
                );

            yield $dto->__toString();
        }
    }
}