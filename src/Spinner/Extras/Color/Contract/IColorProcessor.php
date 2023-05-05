<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\HSLColor;
use AlecRabbit\Spinner\Extras\Color\RGBColor;

interface IColorProcessor
{
    /**
     * Converts a color to RGB.
     *
     * @param string|IColor $color The color to convert.
     *
     * @throws InvalidArgumentException
     */
    public function toRGB(string|IColor $color): RGBColor;

    /**
     * Converts a color to HSL.
     *
     * @param string|IColor $color The color to convert.
     *
     * @throws InvalidArgumentException
     */
    public function toHSL(string|IColor $color): HSLColor;

    public function colorFromString(string $color): IColor;

    public function getFloatPrecision(): int;
}
