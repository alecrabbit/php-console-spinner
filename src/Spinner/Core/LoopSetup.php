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
        protected IDriver $driver,
    ) {
    }

    public function setup(): void
    {
        if ($this->settings->isLoopAvailable()) {
            if ($this->settings->isAutoStartEnabled()) {
                $this->registerAutoStart();
            }
            if ($this->settings->isAttachHandlersEnabled()) {
                $this->registerSignalHandlers();
            }
        }
    }

    protected function registerAutoStart(): void
    {
        $this->loop->autoStart();
    }

    protected function registerSignalHandlers(): void
    {
        foreach ($this->signalHandlers() as $signal => $handler) {
            $this->loop->onSignal($signal, $handler);
        }
    }

    protected function signalHandlers(): Traversable
    {
        yield from [
            // @codeCoverageIgnoreStart
            SIGINT => function (): void {
                $this->driver->interrupt();
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
    }
}
