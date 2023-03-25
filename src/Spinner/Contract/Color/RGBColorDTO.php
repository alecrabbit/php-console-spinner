<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Contract\Color;

final readonly class RGBColorDTO
{
    public int $red;
    public int $green;
    public int $blue;
    public float $alpha;

    public function __construct(
        int $red,
        int $green,
        int $blue,
        float $alpha = 1.0,
    ) {
        $this->red = self::refineColor($red);
        $this->green = self::refineColor($green);
        $this->blue = self::refineColor($blue);
        $this->alpha = self::refineAlpha($alpha);
    }

    private static function refineColor(int $value): int
    {
        return (int)max(0, min(255, $value));
    }

    private static function refineAlpha(float $value): float
    {
        return (float)max(0.0, min(1.0, $value));
    }
}