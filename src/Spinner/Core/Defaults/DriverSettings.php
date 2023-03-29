<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

final class DriverSettings implements IDriverSettings {

    public function getFinalMessage(): string
    {
        // TODO: Implement getFinalMessage() method.
    }

    public function setFinalMessage(string $finalMessage): IDriverSettings
    {
        // TODO: Implement setFinalMessage() method.
    }

    public function getInterruptMessage(): string
    {
        // TODO: Implement getInterruptMessage() method.
    }

    public function setInterruptMessage(string $interruptMessage): IDriverSettings
    {
        // TODO: Implement setInterruptMessage() method.
    }
}