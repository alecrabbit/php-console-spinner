<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Helper\Asserter;
use Traversable;

final class LoopSetup implements ILoopSetup
{
    protected bool $asynchronous = false;
    protected bool $signalHandlersEnabled = false;
    protected bool $autoStartEnabled = false;

    public function __construct(
        protected ILoop $loop,
    ) {
    }

    public function setup(ISpinner $spinner): void
    {
        if ($this->asynchronous) {
            if ($this->autoStartEnabled) {
                $this->registerAutoStart();
            }
            if ($this->signalHandlersEnabled) {
                $this->registerSignalHandlers($spinner);
            }
        }
    }

    protected function registerAutoStart(): void
    {
        $this->loop->autoStart();
    }

    protected function registerSignalHandlers(ISpinner $spinner): void
    {
        $handlers =
            $this->getSignalHandlers($spinner);

        foreach ($handlers as $signal => $handler) {
            $this->loop->onSignal($signal, $handler);
        }
    }

    protected function getSignalHandlers(ISpinner $spinner): Traversable
    {
        Asserter::assertExtensionLoaded(
            'pcntl',
            'Signal handling requires the pcntl extension.'
        );

        yield from [
            // @codeCoverageIgnoreStart
            SIGINT => function () use ($spinner): void {
                $spinner->interrupt();
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
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
