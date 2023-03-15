<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Contract\ColorMode;

interface ITerminalSettings
{
    public function getWidth(): int;

    public function setWidth(int $width): static;

    public function getColorMode(): ColorMode;

    public function setColorMode(ColorMode $colorMode): static;

    public function isHideCursor(): bool;
}