<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Legacy\Terminal\Contract\ITerminalLegacyProbe;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyTerminalSettings;


/**
 * @deprecated Will be removed
 */
final class LegacyTerminalSettingsFactory implements \AlecRabbit\Spinner\Core\Legacy\ILegacyTerminalSettingsFactory
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
