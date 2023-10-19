<?php

declare(strict_types=1);

namespace AlecRabbit\Stopwatch\Contract\Factory;

interface IReportFactory
{
    public function report(): string;
}
