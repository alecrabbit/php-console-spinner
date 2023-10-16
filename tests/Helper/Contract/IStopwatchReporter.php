<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Contract;

interface IStopwatchReporter
{
    public function report(IStopwatch $stopwatch): void;
}
