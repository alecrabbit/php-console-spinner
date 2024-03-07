<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportLoopSetup;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final readonly class MemoryReportLoopSetup implements IMemoryReportLoopSetup
{
    public function __construct(
        private IDriver $driver,
        private IMemoryUsageReporter $reporter,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        $report = $this->driver->wrap(
            $this->reporter->report(...),
        );

        $loop->delay(0, $report); // Initial report

        $interval = $this->reporter->getReportInterval();

        $loop->repeat($interval, $report);
    }
}
