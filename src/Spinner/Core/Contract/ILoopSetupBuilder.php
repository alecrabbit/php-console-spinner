<?php

declare(strict_types=1);

// 06.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

interface ILoopSetupBuilder
{
    public function build(): ILoopSetup;

    public function withSettings(ILoopSettings $settings): ILoopSetupBuilder;

    public function withLoop(ILoop $loop): ILoopSetupBuilder;
}
