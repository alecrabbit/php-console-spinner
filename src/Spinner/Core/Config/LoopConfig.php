<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersContainer;

final readonly class LoopConfig implements ILoopConfig
{
    public function __construct(
        protected AutoStartMode $autoStartMode,
        protected SignalHandlingMode $signalHandlersMode,
        protected ISignalHandlersContainer $signalHandlersContainer,
    ) {
    }

    public function getAutoStartMode(): AutoStartMode
    {
        return $this->autoStartMode;
    }

    public function getSignalHandlingMode(): SignalHandlingMode
    {
        return $this->signalHandlersMode;
    }

    /**
     * @return class-string<ILoopConfig>
     */
    public function getIdentifier(): string
    {
        return ILoopConfig::class;
    }

    public function getSignalHandlersContainer(): ISignalHandlersContainer
    {
        return $this->signalHandlersContainer;
    }
}
