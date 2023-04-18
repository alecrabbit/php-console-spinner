<?php

declare(strict_types=1);
// 18.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Core\Defaults\TerminalSettings;

final class TerminalSettingsFactory implements Contract\ITerminalSettingsFactory
{
    
    public function createTerminalSettings(): ITerminalSettings
    {
        return
            new TerminalSettings(
                optionCursor: OptionCursor::HIDDEN,
                optionStyleMode: OptionStyleMode::ANSI8,
                outputStream: STDERR,
            );
    }
}
