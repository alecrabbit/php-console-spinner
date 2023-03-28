<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

interface ITerminalSettings extends IDefaultsChild
{
    public static function getInstance(
        IDefaults $parent,
        OptionStyleMode $styleMode,
        int $width,
        OptionCursor $cursor,
    ): ITerminalSettings;

    public function getWidth(): int;

    public function overrideWidth(int $width): static;

    public function getStyleMode(): OptionStyleMode;

    public function overrideColorMode(OptionStyleMode $colorMode): static;

    public function isCursorDisabled(): bool;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideSupportedColorModes(Traversable $supportedColorModes): static;

    public function getSupportedColorModes(): Traversable;

    public function overrideCursor(OptionCursor $cursor): static;
}
