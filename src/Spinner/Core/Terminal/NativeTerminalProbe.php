<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
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

    public function getOptionStyleMode(): StylingMethodOption
    {
        return self::DEFAULT_OPTION_STYLE_MODE;
    }

    public function getOutputStream()
    {
        return STDERR;
    }
}
