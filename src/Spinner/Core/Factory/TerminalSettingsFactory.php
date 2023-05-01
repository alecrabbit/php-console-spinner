<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Settings\TerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;

final class TerminalSettingsFactory implements Contract\ITerminalSettingsFactory
{
    public function __construct(
        protected ITerminalProbe $terminalProbe,
    ) {
    }

    public function createTerminalSettings(): ITerminalSettings
    {
        return
            new TerminalSettings(
                optionCursor: $this->terminalProbe->getOptionCursor(),
                optionStyleMode: $this->terminalProbe->getOptionStyleMode(),
                outputStream: $this->terminalProbe->getOutputStream(),
            );
    }
}
