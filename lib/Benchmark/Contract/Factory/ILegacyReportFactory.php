<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Contract\Factory;

interface ILegacyReportFactory
{
    public function report(): string;
}
