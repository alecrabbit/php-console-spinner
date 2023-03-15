<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Contract;

use Closure;

interface ILoopAdapter extends ISpinnerAttacher, ILoopSignalHandlers
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): void;

    public function delay(float $delay, Closure $closure): void;

    public function autoStart(): void; // TODO: choose a better name
}
