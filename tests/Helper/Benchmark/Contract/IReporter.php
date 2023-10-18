<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark\Contract;

interface IReporter
{
    public function report(): void;
}
