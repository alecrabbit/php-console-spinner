<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
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
            if ($this->settings->isAttachHandlersEnabled()) {
                $this->registerSignalHandlers($driver);
            }
        }
    }

    protected function registerAutoStart(): void
    {
        $this->loop->autoStart();
    }

    protected function registerSignalHandlers(IDriver $driver): void
    {
        foreach ($this->signalHandlers($driver) as $signal => $handler) {
            $this->loop->onSignal($signal, $handler);
        }
    }

    protected function signalHandlers(IDriver $driver): Traversable
    {
        yield from [
            // @codeCoverageIgnoreStart
            SIGINT => function () use ($driver): void {
                $driver->interrupt('SIGINT'); // todo: test
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
    }
}
