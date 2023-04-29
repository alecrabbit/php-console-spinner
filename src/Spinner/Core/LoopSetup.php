<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use Traversable;

final class LoopSetup implements ILoopSetup
{
    public function __construct(
        protected ILoop $loop,
        protected ILoopSettings $settings,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        if ($this->settings->isLoopAvailable()) {
            if ($this->settings->isAutoStartEnabled()) {
                $this->registerAutoStart();
            }
            if ($this->settings->isSignalProcessingAvailable() && $this->settings->isAttachHandlersEnabled()) {
                $this->registerSignalHandlers($driver);
            }
        }
    }

    private function registerAutoStart(): void
    {
        $this->loop->autoStart();
    }

    private function registerSignalHandlers(IDriver $driver): void
    {
        foreach ($this->signalHandlers($driver) as $signal => $handler) {
            $this->loop->onSignal($signal, $handler);
        }
    }

    private function signalHandlers(IDriver $driver): Traversable
    {
        yield from [
            // @codeCoverageIgnoreStart
            SIGINT => function () use ($driver): void {
                $driver->interrupt(PHP_EOL . 'SIGINT' . PHP_EOL); // todo: test
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
    }
}