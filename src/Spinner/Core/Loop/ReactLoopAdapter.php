<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
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
        $this->detachPrevious();
        $this->spinnerTimer = $this->loop->addPeriodicTimer(
            $spinner->getInterval()->toSeconds(),
            static fn() => $spinner->spin()
        );
    }

    private function detachPrevious(): void
    {
        if ($this->spinnerTimer instanceof TimerInterface) {
            $this->loop->cancelTimer($this->spinnerTimer);
        }
    }

    public function autoStart(): void
    {
        // ReactPHP event loop is started by library code.
    }

    public function repeat(float $interval, Closure $closure): void
    {
        $this->loop->addPeriodicTimer($interval, $closure);
    }

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    public function delay(float $delay, Closure $closure): void
    {
        $this->loop->addTimer($delay, $closure);
    }

    protected function onSignal(int $signal, mixed $closure): void
    {
        $this->loop->addSignal($signal, $closure);
    }
}
