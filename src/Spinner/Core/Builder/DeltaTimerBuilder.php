<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\DeltaTimer;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DeltaTimerBuilder implements IDeltaTimerBuilder
{
    private ?float $startTime = null;
    private ?INowTimer $nowTimer = null;

    public function build(): IDeltaTimer
    {
        $this->validate();

        return
            new DeltaTimer(
                now: $this->nowTimer,
                startTime: $this->startTime,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->startTime === null => throw new LogicException('Start time is not set.'),
            $this->nowTimer === null => throw new LogicException('NowTimer is not set.'),
            default => null,
        };
    }

    public function withStartTime(float $time): IDeltaTimerBuilder
    {
        $clone = clone $this;
        $clone->startTime = $time;
        return $clone;
    }

    public function withNowTimer(INowTimer $now): IDeltaTimerBuilder
    {
        $clone = clone $this;
        $clone->nowTimer = $now;
        return $clone;
    }
}
