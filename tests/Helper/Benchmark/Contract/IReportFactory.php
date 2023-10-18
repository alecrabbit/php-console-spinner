<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper\Benchmark\Contract;

interface IReportFactory
{
    public function report(): string;
}
