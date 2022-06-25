<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;

interface ILoop
{
    public function periodic(int|float $interval, callable $callback): void;

    public function defer(int|float $interval, callable $callback): void;

    public function addHandler(int $signal, callable $callback): void;

    public function removeHandler(int $signal, callable $callback);

    public function stop(): void;
}
