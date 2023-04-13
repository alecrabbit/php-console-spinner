<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use Closure;

final class TimerBuilder implements ITimerBuilder
{
    protected ?float $startingTime = null;
    protected ?Closure $timeFunction = null;

    public function build(): ITimer
    {
        $this->validate();

        return
            new Timer(
                timeFunction: $this->timeFunction,
                time: $this->startingTime,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->startingTime => throw new LogicException('Starting time is not set.'),
            null === $this->timeFunction => throw new LogicException('Time function is not set.'),
            default => null,
        };
    }

    public function withStartTime(float $time): ITimerBuilder
    {
        $clone = clone $this;
        $clone->startingTime = $time;
        return $clone;
    }

    public function withTimeFunction(Closure $timeFunction): ITimerBuilder
    {
        $clone = clone $this;
        $clone->timeFunction = $timeFunction;
        return $clone;
    }
}
