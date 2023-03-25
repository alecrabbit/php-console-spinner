<?php

declare(strict_types=1);
// 22.03.23
namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\Color\HSLColorDTO;
use AlecRabbit\Spinner\Contract\Color\IColorDTO;
use AlecRabbit\Spinner\Contract\Color\RGBColorDTO;
use Generator;
use Traversable;

interface IColorConverter
{
    public function toRGB(string|IColorDTO $color): RGBColorDTO;

    public function toHSL(string|IColorDTO $color): HSLColorDTO;

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     */
    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator;

}
