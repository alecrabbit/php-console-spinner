<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Contract\Cursor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

interface ITerminalSettings extends IDefaultsChild
{
    public static function getInstance(
        IDefaults $parent,
        ColorMode $colorMode,
        int $width,
        Cursor $cursor,
    ): ITerminalSettings;

    public function getWidth(): int;

    public function setWidth(int $width): static;

    public function getColorMode(): ColorMode;

    public function setColorMode(ColorMode $colorMode): static;

    public function isCursorDisabled(): bool;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideSupportedColorModes(Traversable $supportedColorModes): static;

    public function getSupportedColorModes(): Traversable;

    public function overrideCursor(Cursor $cursor): static;
}
