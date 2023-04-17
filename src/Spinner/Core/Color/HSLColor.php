<?php

declare(strict_types=1);

// 25.03.23

namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;

final class HSLColor implements IColor
{
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
        $this->saturation = self::refineSaturation($saturation);
        $this->lightness = self::refineLightness($lightness);
        $this->alpha = self::refineAlpha($alpha);
    }

    private static function refineHue(int $value): int
    {
        return max(0, min(360, $value));
    }

    private static function refineSaturation(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }

    private static function refineLightness(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }

    private static function refineAlpha(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }
}
