<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoop
{
    public function addPeriodicTimer(int|float $interval, callable $callback): void;

    public function addTimer(int|float $interval, callable $callback): void;

    public function addSignal(int $signal, callable $callback): void;

    public function removeSignal(int $signal, callable $callback);

    public function stop(): void;
}
