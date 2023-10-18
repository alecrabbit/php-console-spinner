<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper\Benchmark\Contract;

interface IReportFactory
{
    public function report(): string;
}
