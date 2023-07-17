<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface ITerminalSettings
{
    public function getOptionCursor(): CursorVisibilityOption;

    public function setOptionCursor(CursorVisibilityOption $cursorOption): ITerminalSettings;

    public function getOptionStyleMode(): StylingMethodOption;

    public function setOptionStyleMode(StylingMethodOption $optionStyleMode): ITerminalSettings;

    /**
     * @return resource
     */
    public function getOutputStream();

    /**
     * @param resource $outputStream
     */
    public function setOutputStream($outputStream): ITerminalSettings;
}
