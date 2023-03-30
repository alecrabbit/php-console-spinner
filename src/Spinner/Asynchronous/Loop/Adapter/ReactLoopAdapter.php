<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Asynchronous\Loop\Adapter;

use AlecRabbit\Spinner\Core\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use Closure;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

class ReactLoopAdapter extends ALoopAdapter
{
    private ?TimerInterface $spinnerTimer = null;

    public function __construct(
        private readonly LoopInterface $loop,
    ) {
    }

    public function attach(ISpinner $spinner): void
    {
        $this->detachSpinner();
        $this->spinnerTimer =
            $this->loop->addPeriodicTimer(
                $spinner->getInterval()->toSeconds(),
                static fn() => $spinner->spin()
            );
    }

    protected function detachSpinner(): void
    {
        if ($this->spinnerTimer instanceof TimerInterface) {
            $this->loop->cancelTimer($this->spinnerTimer);
        }
    }

    public function autoStart(): void
    {
        // ReactPHP event loop is started by its library code.
    }

    public function repeat(float $interval, Closure $closure): void
    {
        $this->loop->addPeriodicTimer($interval, $closure);
    }

    public function delay(float $delay, Closure $closure): void
    {
        $this->loop->addTimer($delay, $closure);
    }

    public function run(): void
    {
        $this->getLoop()->run();
    }

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    public function stop(): void
    {
        $this->getLoop()->stop();
    }

    protected function onSignal(int $signal, Closure $closure): void
    {
        $this->loop->addSignal($signal, $closure);
    }
}
