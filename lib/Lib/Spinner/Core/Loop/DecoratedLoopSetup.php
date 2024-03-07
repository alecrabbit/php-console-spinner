<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportPrinter;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class DecoratedLoopSetup implements IAdditionalLoopSetup
{
    public function __construct(
        private IMemoryReportPrinter $memoryReportPrinter,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        $this->setupMemoryReport($loop);
    }

    private function setupMemoryReport(ILoop $loop): void
    {
        $this->memoryReportPrinter->print();

        $loop->repeat(
            $this->memoryReportPrinter->getReportInterval(),
            $this->memoryReportPrinter->print(...),
        );
    }
}
