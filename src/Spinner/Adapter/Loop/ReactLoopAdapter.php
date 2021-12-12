<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Adapter\Loop;

use AlecRabbit\Spinner\Contract\ILoop;
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
}
