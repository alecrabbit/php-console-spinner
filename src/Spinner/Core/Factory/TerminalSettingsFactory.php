<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;

final class TerminalSettingsFactory implements Contract\ITerminalSettingsFactory
{
    public function __construct(
        protected ITerminalProbe $terminalProbe,
    ) {
    }

    public function createTerminalSettings(): ILegacyTerminalSettings
    {
        return
            new LegacyTerminalSettings(
                optionCursor: $this->terminalProbe->getOptionCursor(),
                optionStyleMode: $this->terminalProbe->getOptionStyleMode(),
                outputStream: $this->terminalProbe->getOutputStream(),
            );
    }
}
