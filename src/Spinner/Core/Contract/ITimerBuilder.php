<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\ITimer;
use Closure;

interface ITimerBuilder
{
    public function build(): ITimer;

    public function withStartTime(float $time): ITimerBuilder;

    public function withTimeFunction(Closure $timeFunction): ITimerBuilder;
}
