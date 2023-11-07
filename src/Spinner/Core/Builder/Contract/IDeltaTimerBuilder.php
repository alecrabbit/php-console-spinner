<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;
use Closure;

interface IDeltaTimerBuilder
{
    public function build(): IDeltaTimer;

    public function withStartTime(float $time): IDeltaTimerBuilder;

    public function withNow(INow $now): IDeltaTimerBuilder;
}
