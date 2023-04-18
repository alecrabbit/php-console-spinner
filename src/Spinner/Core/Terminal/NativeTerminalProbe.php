<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;

final class NativeTerminalProbe extends ATerminalProbe
{
    public function isAvailable(): bool
    {
        return true;
    }

    public function getWidth(): int
    {
        return self::DEFAULT_TERMINAL_WIDTH;
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        return self::DEFAULT_OPTION_STYLE_MODE;
    }

    public function getOutputStream()
    {
        return STDERR;
    }
}
