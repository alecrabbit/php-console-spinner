<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;

interface IDeltaTimerBuilder
{
    public function build(): IDeltaTimer;

    public function withStartTime(float $time): IDeltaTimerBuilder;

    public function withNowTimer(INowTimer $now): IDeltaTimerBuilder;
}
