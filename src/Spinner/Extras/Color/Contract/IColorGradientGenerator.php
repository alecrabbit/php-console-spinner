<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\RGBColor;
use Generator;
use Traversable;

interface IColorGradientGenerator
{
    /**
     * Generates a gradient of colors between two colors.
     *
     * @param IColor|string $from The starting color of the gradient.
     * @param IColor|string $to The ending color of the gradient.
     * @param int $count The number of colors in the resulting gradient. Minimum 2.
     *
     * @return Generator<RGBColor> A generator that yields RGBColor objects.
     *
     * @throws InvalidArgumentException if the parameters are invalid.
     */
    public function gradient(IColor|string $from, IColor|string $to, int $count = 2): Generator;

    /**
     * Generates gradients of colors between pairs of colors.
     *
     * @param Traversable $colors Colors to generate gradients.
     * @param int $num The number of colors between supplied colors. Minimum 2.
     * @param string|null|IColor $fromColor Optional. The starting color of the gradient.
     *
     * @return Generator<RGBColor> A generator that yields RGBColor objects.
     *
     * @throws InvalidArgumentException
     */
    public function gradients(Traversable $colors, int $num = 2, IColor|string|null $fromColor = null): Generator;
}
