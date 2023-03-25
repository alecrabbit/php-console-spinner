<?php

declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
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

    /**
     * @throws InvalidArgumentException
     */
    public static function fromHex(string $hex): self
    {
        self::assertHex($hex);

        $hex = str_replace('#', '', $hex);

        $length = strlen($hex);
        if (3 === $length) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            $length = strlen($hex);
        }

        $cLength = (int)($length / 3);
        return
            new self(
                hexdec(substr($hex, 0, $cLength)),
                hexdec(substr($hex, $cLength, $cLength)),
                hexdec(substr($hex, $cLength * 2, $cLength)),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertHex(string $hex): void
    {
        Asserter::assertHexStringColor($hex);
    }

    public function __toString(): string
    {
        return sprintf(self::HEX_FORMAT, $this->red, $this->green, $this->blue);
    }

}