<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class LoopConfigBuilder implements ILoopConfigBuilder
{
    private ?AutoStartMode $autoStartMode = null;
    private ?SignalHandlingMode $signalHandlersMode = null;

    /**
     * @inheritDoc
     */
    public function build(): ILoopConfig
    {
        $this->validate();

        return
            new LoopConfig(
                autoStartMode: $this->autoStartMode,
                signalHandlersMode: $this->signalHandlersMode,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->autoStartMode === null => throw new LogicException('AutoStartMode is not set.'),
            $this->signalHandlersMode === null => throw new LogicException('SignalHandlingMode is not set.'),
            default => null,
        };
    }

    public function withAutoStartMode(AutoStartMode $autoStartMode): ILoopConfigBuilder
    {
        $clone = clone $this;
        $clone->autoStartMode = $autoStartMode;
        return $clone;
    }

    public function withSignalHandlingMode(SignalHandlingMode $signalHandlersMode): ILoopConfigBuilder
    {
        $clone = clone $this;
        $clone->signalHandlersMode = $signalHandlersMode;
        return $clone;
    }
}
