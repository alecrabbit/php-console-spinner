<?php

declare(strict_types=1);
// 06.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopSetupBuilder implements ILoopSetupBuilder
{

    protected ?ILoop $loop = null;
    protected ?ILoopConfig $config = null;

    public function build(): ILoopSetup
    {
        if (null === $this->loop) {
            throw new LogicException('Loop is not set.');
        }
        if (null === $this->config) {
            throw new LogicException('Loop config is not set.');
        }

        return
            (new LoopSetup($this->loop))
                ->asynchronous($this->config->isRunModeAsynchronous())
                ->enableAutoStart($this->config->isEnabledAutoStart())
                ->enableSignalHandlers($this->config->isEnabledAttachHandlers())
        ;
    }

    public function withConfig(ILoopConfig $config): ILoopSetupBuilder
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }

    public function withLoop(ILoop $loop): ILoopSetupBuilder
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }
}
