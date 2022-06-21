<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Config\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContainer;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;
use AlecRabbit\Spinner\Kernel\Contract\IDriver;
use AlecRabbit\Spinner\Kernel\Contract\ILoop;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;

interface IConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function getLoop(): ILoop;

    public function getShutdownDelay(): int|float;

    public function getInterruptMessage(): string;

    public function getDriver(): IDriver;

    public function getWigglers(): IWigglerContainer;

    public function getColorSupportLevel(): int;

    public function getFinalMessage(): string;

    public function getContainer(): ITwirlerContainer;

    public function getTwirlerFactory(): ITwirlerFactory;
}
