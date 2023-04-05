<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Helper\Asserter;

final class LoopSetup implements ILoopSetup
{
    protected bool $asynchronous = false;
    protected bool $signalHandlersEnabled = false;
    protected bool $autoStartEnabled = false;

    public function __construct(
        protected ILoopAdapter $loop,
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
        $loop = $this->loop;

        $handlers =
            $this->createSignalHandlers($spinner, $loop);

        foreach ($handlers as $signal => $handler) {
            $loop->onSignal($signal, $handler);
        }
    }

    private function createSignalHandlers(ISpinner $spinner, ILoopAdapter $loop): \Traversable
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
