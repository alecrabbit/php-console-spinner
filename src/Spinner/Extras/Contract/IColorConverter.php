<?php

declare(strict_types=1);
// 22.03.23
namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\HSLColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use Generator;
use Traversable;

interface IColorConverter
{
    public function toRGB(string|IColor $color): RGBColor;

    public function toHSL(string|IColor $color): HSLColor;

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     */
    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator;

}
