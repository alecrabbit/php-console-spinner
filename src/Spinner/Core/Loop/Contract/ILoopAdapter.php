<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use Closure;

interface ILoopAdapter
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): mixed;

    public function cancel(mixed $timer): void;

    public function delay(float $delay, Closure $closure): void;

    public function autoStart(): void; // TODO: choose a better name
}
