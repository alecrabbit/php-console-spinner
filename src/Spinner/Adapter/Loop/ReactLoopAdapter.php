<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Adapter\Loop;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use React\EventLoop\LoopInterface;

final class ReactLoopAdapter implements ILoop
{
    public function __construct(
        private LoopInterface $loop,
    ) {
    }

    public function addPeriodicTimer(int|float $interval, callable $callback): void
    {
        $this->loop->addPeriodicTimer($interval, $callback);
    }

    public function addTimer(int|float $interval, callable $callback): void
    {
        $this->loop->addTimer($interval, $callback);
    }

    public function addSignal(int $signal, callable $callback): void
    {
        $this->loop->addSignal($signal, $callback);
    }

    public function removeSignal(int $signal, callable $callback): void
    {
        $this->loop->removeSignal($signal, $callback);
    }

    public function stop(): void
    {
        $this->loop->stop();
    }
}
