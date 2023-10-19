<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch\Contract;

interface ITimer
{
    public function getUnit(): TimeUnit;

    public function now(): int|float;
}
