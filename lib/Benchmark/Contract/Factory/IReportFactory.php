<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

use AlecRabbit\Benchmark\Contract\IReport;

interface IReportFactory
{
    public function create(): IReport;
}
