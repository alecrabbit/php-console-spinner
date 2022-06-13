<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface ISpinnerConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function getLoop(): ILoop;

    public function getShutdownDelay(): int|float;

    public function getExitMessage(): string;

    public function getInterval(): IInterval;

    public function getDriver(): IDriver;

    public function getWigglers(): IWigglerContainer;

    public function getColorSupportLevel(): int;

    public function getFinalMessage(): string;
}
