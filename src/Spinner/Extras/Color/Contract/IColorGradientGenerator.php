<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Generator;

interface IColorGradientGenerator
{
    /**
     * Generates a gradient of colors between two colors.
     *
     * @param string|IColor $from The starting color of the gradient.
     * @param string|IColor $to The ending color of the gradient.
     * @param int $count The number of colors in the resulting gradient. Minimum 2.
     *
     * @return Generator<RGBColor> A generator that yields RGBColor objects.
     *
     * @throws InvalidArgumentException if the parameters are invalid.
     */
    public function gradient(string|IColor $from, string|IColor $to, int $count = 2): Generator;

//    /**
//     * Generates gradients of colors between pairs of colors.
//     *
//     * @param Traversable $colors Colors to generate gradients.
//     * @param int $steps The number of steps in the gradient.
//     * @param string|null $fromColor Optional. The starting color of the gradient.
//     *
//     * @return Generator<RGBColor> A generator that yields RGBColor objects.
//     *
//     * @throws InvalidArgumentException
//     */
//    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator;
//
}
