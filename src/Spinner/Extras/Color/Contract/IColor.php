<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Extras\Color\Contract;

use Stringable;

interface IColor extends Stringable
{
    public static function fromHexString(string $hex): IColor;

    public static function fromRGB(int $r, int $g, int $b): IColor;

    public static function fromHSL(int $hue, float $saturation = 1.0, float $lightness = 0.5): IColor;

    public function getBlue(): int;

    public function getGreen(): int;

    public function getLightness(): float;

    public function getHue(): int;

    public function getRed(): int;

    public function getSaturation(): float;
}