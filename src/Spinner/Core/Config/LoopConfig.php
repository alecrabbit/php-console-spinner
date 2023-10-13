<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;

final readonly class LoopConfig implements ILoopConfig
{
    public function __construct(
        protected AutoStartMode $autoStartMode,
        protected SignalHandlersMode $signalHandlersMode,
    ) {
    }

    public function getAutoStartMode(): AutoStartMode
    {
        return $this->autoStartMode;
    }

    public function getSignalHandlersMode(): SignalHandlersMode
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
}
