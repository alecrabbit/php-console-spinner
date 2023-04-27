<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;

interface ITerminalSettings
{
    public function getOptionCursor(): OptionCursor;

    public function setOptionCursor(OptionCursor $cursorOption): ITerminalSettings;

    public function getOptionStyleMode(): OptionStyleMode;

    public function setOptionStyleMode(OptionStyleMode $optionStyleMode): ITerminalSettings;

    /**
     * @return resource
     */
    public function getOutputStream();

    /**
     * @param resource $outputStream
     */
    public function setOutputStream($outputStream): ITerminalSettings;
}
