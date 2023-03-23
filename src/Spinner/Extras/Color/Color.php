<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

final class Color extends AColor
{
    protected const STR_FORMAT = '#%02x%02x%02x';
    protected int $hue;
    protected float $saturation;
    protected float $lightness;

    public function __construct(
        protected int $r,
        protected int $g,
        protected int $b,
    ) {
        $this->initHSLValues();
    }

    protected function initHSLValues(): void
    {
        $r = $this->r / 255;
        $g = $this->g / 255;
        $b = $this->b / 255;

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

        $this->hue = (int)round($h * 360);
        $this->saturation = round($s, 2);
        $this->lightness = round($l, 2);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromHexString(string $hex): IColor
    {
        Asserter::assertHexStringColor($hex);

        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $cLength = (int)($length / 3);
        return
            new self(
                hexdec(substr($hex, 0, $cLength)),
                hexdec(substr($hex, $cLength, $cLength)),
                hexdec(substr($hex, $cLength * 2, $cLength)),
            );
    }

    public static function fromRGB(int $r, int $g, int $b): IColor
    {
        return new self($r, $g, $b);
    }

    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IColor
    {
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

        $r = ($r + $m) * 255;
        $g = ($g + $m) * 255;
        $b = ($b + $m) * 255;

        return
            new self((int)$r, (int)$g, (int)$b);
    }

    public function getRed(): int
    {
        return $this->r;
    }

    public function getGreen(): int
    {
        return $this->g;
    }


    public function getBlue(): int
    {
        return $this->b;
    }

    public function __toString(): string
    {
        return
            sprintf(self::STR_FORMAT, $this->r, $this->g, $this->b);
    }

    public function getHue(): int
    {
        return $this->hue;
    }

    public function getSaturation(): float
    {
        return $this->saturation;
    }

    public function getLightness(): float
    {
        return $this->lightness;
    }
}