<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\HSLColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\ColorProcessor;
use Generator;
use Traversable;

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
