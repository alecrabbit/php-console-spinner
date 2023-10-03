<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Contract\ILegacyProbe;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface ITerminalLegacyProbe extends ILegacyProbe
{
    final public const DEFAULT_OPTION_CURSOR = CursorVisibilityOption::HIDDEN;
    final public const DEFAULT_TERMINAL_WIDTH = 100;
    final public const DEFAULT_OPTION_STYLE_MODE = StylingMethodOption::ANSI8;

    public function getWidth(): int;

    public function getOptionStyleMode(): StylingMethodOption;

    public function getOptionCursor(): CursorVisibilityOption;

    /**
     * @return resource
     */
    public function getOutputStream();
}
