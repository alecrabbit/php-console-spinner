<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface ILegacyTerminalSettings
{
    public function getOptionCursor(): CursorVisibilityOption;

    public function setOptionCursor(CursorVisibilityOption $cursorOption): ILegacyTerminalSettings;

    public function getOptionStyleMode(): StylingMethodOption;

    public function setOptionStyleMode(StylingMethodOption $optionStyleMode): ILegacyTerminalSettings;

    /**
     * @return resource
     */
    public function getOutputStream();

    /**
     * @param resource $outputStream
     */
    public function setOutputStream($outputStream): ILegacyTerminalSettings;
}
