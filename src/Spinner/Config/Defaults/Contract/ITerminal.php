<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Config\Defaults\Contract;

use AlecRabbit\Spinner\Core\Terminal\ColorMode;

interface ITerminal
{
    final public const TERMINAL_DEFAULT_WIDTH = 100;
    final public const TERMINAL_DEFAULT_COLOR_SUPPORT = ColorMode::ANSI8;
    final public const TERMINAL_DEFAULT_HIDE_CURSOR = true;

    public function getWidth(): int;

    public function setWidth(int $width): static;

    public function getColorMode(): ColorMode;

    public function setColorMode(ColorMode $colorMode): static;

    public function isHideCursor(): bool;
}