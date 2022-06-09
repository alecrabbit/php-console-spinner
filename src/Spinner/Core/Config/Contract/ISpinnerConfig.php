<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;

interface ISpinnerConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function getLoop(): ILoop;

    public function getShutdownDelay(): int|float;

    public function getExitMessage(): string;

    public function getSpinnerClass(): string;

    public function getInterval(): int|float;

    public function getDriver(): IDriver;

    public function getWigglers(): IWigglerContainer;
}
