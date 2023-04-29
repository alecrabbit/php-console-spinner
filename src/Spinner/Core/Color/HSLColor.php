<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;

final class HSLColor implements IColor
{
    private const HSL_FORMAT = 'hsl(%d, %s%%, %s%%)';
    private const HSLA_FORMAT = 'hsla(%d, %s%%, %s%%, %s)';

    public int $hue;
    public float $saturation;
    public float $lightness;
    public float $alpha;

    public function __construct(
        int $hue,
        float $saturation = 1.0,
        float $lightness = 0.5,
        float $alpha = 1.0,
    ) {
        $this->hue = self::refineHue($hue);
        $this->saturation = self::refineValue($saturation);
        $this->lightness = self::refineValue($lightness);
        $this->alpha = self::refineValue($alpha);
    }

    private static function refineHue(int $value): int
    {
        return ($value % 360 + 360) % 360;
    }

    private static function refineValue(float $value): float
    {
        return round(max(0.0, min(1.0, $value)), 2);
    }

    public function toHsl(): string
    {
        return
            sprintf(
                self::HSL_FORMAT,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
            );
    }

    public function toHsla(): string
    {
        return
            sprintf(
                self::HSLA_FORMAT,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
                $this->alpha,
            );
    }
}
