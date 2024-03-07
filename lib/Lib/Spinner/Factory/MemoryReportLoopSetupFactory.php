<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Lib\Spinner\Core\Loop\MemoryReportLoopSetup;
use AlecRabbit\Spinner\Core\Contract\IDriver;

final readonly class MemoryReportLoopSetupFactory implements IMemoryReportLoopSetupFactory
{
    public function __construct(
        private IMemoryUsageReporter $reporter,
    ) {
    }

    public function create(IDriver $driver): IMemoryReportLoopSetup
    {
        return new MemoryReportLoopSetup(
            driver: $driver,
            reporter: $this->reporter
        );
    }
}
