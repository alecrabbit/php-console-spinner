<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Lib\Spinner\Core\Loop\MemoryReportLoopSetup;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MemoryReportLoopSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(MemoryReportLoopSetup::class, $provider);
    }

    private function getTesteeInstance(
        ?IDriver $driver = null,
        ?IMemoryUsageReporter $reporter = null,
    ): ILoopSetup {
        return new MemoryReportLoopSetup(
            driver: $driver ?? $this->getDriverMock(),
            reporter: $reporter ?? $this->getMemoryUsageReporterMock(),
        );
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getMemoryUsageReporterMock(): MockObject&IMemoryUsageReporter
    {
        return $this->createMock(IMemoryUsageReporter::class);
    }
}
