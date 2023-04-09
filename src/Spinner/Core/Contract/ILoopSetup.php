<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopSetup
{
    public function setup(ILegacySpinner $spinner): void;

    public function enableSignalHandlers(bool $enable): ILoopSetup;

    public function asynchronous(bool $enable): ILoopSetup;

    public function enableAutoStart(bool $enable): ILoopSetup;

}
