<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDriverSettings
{
    public function getFinalMessage(): string;

    public function setFinalMessage(string $finalMessage): IDriverSettings;

    public function getInterruptMessage(): string;

    public function setInterruptMessage(string $interruptMessage): IDriverSettings;
}
