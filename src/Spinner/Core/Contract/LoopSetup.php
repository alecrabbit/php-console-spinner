<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Contract;

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

    private function registerAutoStart(): void
    {
        $this->loop->autoStart();
    }

    private function registerSignalHandlers(ISpinner $spinner): void
    {
        $handlers =
            $this->getSignalHandlers($spinner, $this->loop);

        foreach ($handlers as $signal => $handler) {
            $this->loop->onSignal($signal, $handler);
        }
    }

    private function getSignalHandlers(ISpinner $spinner, ILoop $loop): Traversable
    {
        Asserter::assertExtensionLoaded(
            'pcntl',
            'Signal handling requires the pcntl extension.'
        );

        yield from [
            SIGINT => function () use ($spinner, $loop): void {
                $spinner->interrupt();
                $loop->stop();
            },
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
