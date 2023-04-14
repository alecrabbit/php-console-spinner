<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract\Loop\Contract;

use Closure;

interface ILoop
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): mixed;

    public function cancel(mixed $timer): void;

    public function delay(float $delay, Closure $closure): void;

    public function onSignal(int $signal, Closure $closure): void;

    public function autoStart(
    ): void; // TODO (2023-04-05 13:11) [Alec Rabbit]: choose a better name and/or move to another interface/class
}
