<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface ILoopConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): ILoopConfig;

    public function withSignalHandlingMode(SignalHandlingMode $signalHandlersMode): ILoopConfigBuilder;

    public function withAutoStartMode(AutoStartMode $autoStartMode): ILoopConfigBuilder;
}
