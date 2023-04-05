<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopSetup implements ILoopSetup
{
    protected bool $asynchronous = false;
    protected bool $signalHandlersEnabled = false;
    protected bool $autoStartEnabled = false;

    public function __construct(
        protected ILoopFactory $loopFactory,
    ) {
    }

    public function setup(): void
    {
        if ($this->asynchronous) {
            if ($this->autoStartEnabled) {
                $this->loopFactory->registerAutoStart();
            }
            if ($this->signalHandlersEnabled) {
                $this->loopFactory->registerSignalHandlers();
            }
        }
    }

    public function asynchronous(bool $enable): ILoopSetup
    {
        $this->asynchronous = $enable;
        return $this;
    }

    public function enableSignalHandlers(bool $enable): ILoopSetup
    {
        $this->signalHandlersEnabled = $enable;
        return $this;
    }

    public function enableAutoStart(bool $enable): ILoopSetup
    {
        $this->autoStartEnabled = $enable;
        return $this;
    }
}
