<?php

declare(strict_types=1);
// 22.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use Generator;
use Traversable;

interface IColorConverter
{
    public function hslToRgb(int $hue, float $s = 1.0, float $l = 0.5): string;

    public function rgbToHsl(string $color): array;

    /**
     * @param Traversable $colors Colors to generate gradients between
     * @param int $steps Steps per gradient
     */
    public function gradients(Traversable $colors, int $steps = 10, ?string $fromColor = null): Generator;

}
