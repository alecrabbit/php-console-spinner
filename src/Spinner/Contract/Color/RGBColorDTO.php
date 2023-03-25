<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Contract\Color;

use Stringable;

final readonly class RGBColorDTO implements Stringable, IColorDTO
{
    private const HEX_FORMAT = '#%02x%02x%02x';
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
        return max(0, min(255, $value));
    }

    private static function refineAlpha(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }

    public function __toString(): string
    {
        return sprintf(self::HEX_FORMAT, $this->red, $this->green, $this->blue);
    }
}