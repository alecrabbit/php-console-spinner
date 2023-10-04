<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalLegacyProbe;


/**
 * @deprecated Will be removed
 */
final class LegacyTerminalSettingsFactory implements Contract\ILegacyTerminalSettingsFactory
{
    public function __construct(
        protected ITerminalLegacyProbe $terminalProbe,
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
