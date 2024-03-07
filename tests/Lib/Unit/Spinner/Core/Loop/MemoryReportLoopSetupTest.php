<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\IMemoryUsageReporter;
use AlecRabbit\Lib\Spinner\Core\Loop\MemoryReportLoopSetup;
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
        ?IMemoryUsageReporter $reporter = null,
    ): ILoopSetup {
        return new MemoryReportLoopSetup(
            reporter: $reporter ?? $this->getMemoryUsageReporterMock(),
        );
    }

    private function getMemoryUsageReporterMock(): MockObject&IMemoryUsageReporter
    {
        return $this->createMock(IMemoryUsageReporter::class);
    }
}
