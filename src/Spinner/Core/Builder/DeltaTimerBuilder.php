<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\DeltaTimer;
use AlecRabbit\Spinner\Exception\LogicException;
use Closure;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DeltaTimerBuilder implements IDeltaTimerBuilder
{
    private ?float $startingTime = null;
    private ?INow $now = null;

    public function build(): IDeltaTimer
    {
        $this->validate();

        return
            new DeltaTimer(
                now: $this->now,
                time: $this->startingTime,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->startingTime === null => throw new LogicException('Starting time is not set.'),
            $this->now === null => throw new LogicException('Now is not set.'),
            default => null,
        };
    }

    public function withStartTime(float $time): IDeltaTimerBuilder
    {
        $clone = clone $this;
        $clone->startingTime = $time;
        return $clone;
    }

    public function withNow(INow $now): IDeltaTimerBuilder
    {
        $clone = clone $this;
        $clone->now = $now;
        return $clone;
    }
}
