<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

use Closure;

interface ILoop
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): mixed;

    public function cancel(mixed $timer): void;

    public function delay(float $delay, Closure $closure): void;

    public function onSignal(int $signal, Closure $closure): void;

    public function autoStart(): void;
}
