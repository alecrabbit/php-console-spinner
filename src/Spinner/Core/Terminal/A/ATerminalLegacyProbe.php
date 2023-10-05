<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalLegacyProbe;

/**
 * @deprecated
 */
abstract class ATerminalLegacyProbe implements ITerminalLegacyProbe
{
    abstract public function isAvailable(): bool;

    abstract public function getWidth(): int;

    abstract public function getOptionStyleMode(): StylingMethodOption;

    public function getOptionCursor(): CursorVisibilityOption
    {
        return ITerminalLegacyProbe::DEFAULT_OPTION_CURSOR;
    }

    /** @inheritDoc */
    abstract public function getOutputStream();
}
