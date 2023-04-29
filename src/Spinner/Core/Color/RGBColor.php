<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Color\IStringableColor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class RGBColor implements IStringableColor
{
    private const HEX_FORMAT = '#%02x%02x%02x';
    private const RGB_FORMAT = 'rgb(%d, %d, %d)';
    private const RGBA_FORMAT = 'rgba(%d, %d, %d, %s)';

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
        if (preg_match('/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/', $color, $matches)) {
            return
                new RGBColor(
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
        self::assertHex($hex);

        $hex = str_replace('#', '', $hex);

        $length = strlen($hex);
        if ($length === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            $length = strlen($hex);
        }

        $cLength = (int)($length / 3);
        return new self(
            hexdec(substr($hex, 0, $cLength)),
            hexdec(substr($hex, $cLength, $cLength)),
            hexdec(substr($hex, $cLength * 2, $cLength)),
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertHex(string $hex): void
    {
        if (!preg_match('/^#?([a-f\d]{2}){3}|#?([a-f\d]){3}$/i', $hex)) { // /^#?([a-f\d]{2}){3}|#?([a-f\d]){3}$/i

            throw new InvalidArgumentException(
                sprintf('Invalid hex color: %s', $hex)
            );
        }
    }

    public function __toString(): string
    {
        return $this->toHex();
    }

    public function toHex(): string
    {
        return sprintf(self::HEX_FORMAT, $this->red, $this->green, $this->blue);
    }

    public function toRgb(): string
    {
        return sprintf(self::RGB_FORMAT, $this->red, $this->green, $this->blue);
    }

    public function toRgba(): string
    {
        return sprintf(self::RGBA_FORMAT, $this->red, $this->green, $this->blue, $this->alpha);
    }
}
