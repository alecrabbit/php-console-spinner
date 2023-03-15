<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Core\ColorMode;

interface ITerminalSettings
{

    public function getWidth(): int;

    public function setWidth(int $width): static; // TODO: choose better name

    public function getColorMode(): ColorMode;

    public function setColorMode(ColorMode $colorMode): static;

    public function isHideCursor(): bool;
}