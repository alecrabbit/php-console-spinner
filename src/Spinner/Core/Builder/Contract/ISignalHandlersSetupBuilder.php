<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\ISignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;

interface ISignalHandlersSetupBuilder
{
    public function build(): ISignalHandlersSetup;

    public function withSettings(ILoopSettings $settings): ISignalHandlersSetupBuilder;

    public function withLoop(ILoop $loop): ISignalHandlersSetupBuilder;
}
