<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

abstract class ATerminalProbe implements ITerminalProbe
{
    use NoInstanceTrait;

    abstract public function isAvailable(): bool;

    abstract public function getWidth(): int;

    abstract public function getOptionStyleMode(): OptionStyleMode;

    public function getOptionCursor(): OptionCursor
    {
        return ITerminalProbe::DEFAULT_OPTION_CURSOR;
    }
}
