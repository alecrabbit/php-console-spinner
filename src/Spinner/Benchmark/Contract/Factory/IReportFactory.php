<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Benchmark\Contract\Factory;

interface IReportFactory
{
    public function report(): string;
}
