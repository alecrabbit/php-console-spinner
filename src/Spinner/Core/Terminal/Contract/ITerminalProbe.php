<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Contract\IProbe;
use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;

interface ITerminalProbe extends IProbe
{
    final public const DEFAULT_OPTION_CURSOR = OptionCursor::HIDDEN;
    final public const DEFAULT_TERMINAL_WIDTH = 100;
    final public const DEFAULT_OPTION_STYLE_MODE = OptionStyleMode::ANSI8;

    public function getWidth(): int;

    public function getOptionStyleMode(): OptionStyleMode;

    public function getOptionCursor(): OptionCursor;

    /**
     * @return resource
     */
    public function getOutputStream();
}
