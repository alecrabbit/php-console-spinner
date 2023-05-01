<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

interface ILoopSetupBuilder
{
    public function build(): ILoopSetup;

    public function withSettings(ILoopSettings $settings): ILoopSetupBuilder;

    public function withLoop(ILoop $loop): ILoopSetupBuilder;
}
