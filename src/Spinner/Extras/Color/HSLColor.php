<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\A\AColor;

final readonly class HSLColor extends AColor
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

    /**
     * @throws InvalidArgumentException
     */
    public static function fromString(string $color): self
    {
        if (preg_match(self::REGEXP_HSLA, $color, $matches)) {
            $h = (int)$matches[1];
            $s = (float)$matches[2] / 100;
            $l = (float)$matches[3] / 100;
            $a = isset($matches[4]) ? (float)$matches[4] : 1.0;
            return
                new self($h, $s, $l, $a);
        }
        throw new InvalidArgumentException(
            sprintf('Invalid color string: "%s".', $color)
        );
    }

    public function toHsl(): string
    {
        return
            sprintf(
                self::FORMAT_HSL,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
            );
    }

    public function toHsla(): string
    {
        return
            sprintf(
                self::FORMAT_HSLA,
                $this->hue,
                round($this->saturation * 100),
                round($this->lightness * 100),
                $this->alpha,
            );
    }
}
