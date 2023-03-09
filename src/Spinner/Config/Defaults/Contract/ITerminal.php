<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Config\Defaults\Contract;

use AlecRabbit\Spinner\Core\ColorMode;

interface ITerminal
{
    public function getWidth(): int;

    public function setWidth(int $width): void;

    public function getColorMode(): ColorMode;

    public function setColorMode(ColorMode $colorMode): void;
}