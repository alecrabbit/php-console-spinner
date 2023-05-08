<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\A\AColor;
use Stringable;

final readonly class RGBColor extends AColor implements Stringable
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
        return max(0, min(255, $value));
    }

    private static function refineAlpha(float $value): float
    {
        return round(max(0.0, min(1.0, $value)), 2);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromString(string $color): self
    {
        if (preg_match(self::REGEXP_RGBA, $color, $matches)) {
            return
                new self(
                    (int)$matches[1],
                    (int)$matches[2],
                    (int)$matches[3],
                    isset($matches[4]) ? (float)$matches[4] : 1.0,
                );
        }
        return self::fromHex($color);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function fromHex(string $hex): self
    {
        $hex = self::normalizeHex($hex);

        return
            new self(
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2)),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function normalizeHex(string $hex): string
    {
        self::assertHex($hex);

        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return $hex;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertHex(string $hex): void
    {
        if (!preg_match(self::REGEXP_HEX, $hex)) {
            throw new InvalidArgumentException(
                sprintf('Invalid color string: "%s".', $hex)
            );
        }
    }

    public function __toString(): string
    {
        return $this->toHexString();
    }

    public function toHexString(): string
    {
        return sprintf(self::FORMAT_HEX, $this->red, $this->green, $this->blue);
    }

    public function toRgbString(): string
    {
        return sprintf(self::FORMAT_RGB, $this->red, $this->green, $this->blue);
    }

    public function toRgbaString(): string
    {
        return sprintf(self::FORMAT_RGBA, $this->red, $this->green, $this->blue, $this->alpha);
    }
}
