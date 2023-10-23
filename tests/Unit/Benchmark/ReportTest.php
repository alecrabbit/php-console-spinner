<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Report;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $report = $this->getTesteeInstance();

        self::assertInstanceOf(Report::class, $report);
    }

    private function getTesteeInstance(
        ?\Traversable $measurements = null,
        ?string $header = null,
        ?string $prefix = null,
    ): IReport {
        return
            new Report(
                measurements: $measurements ?? $this->getMeasurementsMock(),
                header: $header ?? '--header--',
                prefix: $prefix ?? '--prefix--',
            );
    }

    private function getMeasurementsMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    #[Test]
    public function canGetMeasurements(): void
    {
        $measurements = $this->getMeasurementsMock();

        $report = $this->getTesteeInstance($measurements);

        self::assertSame($measurements, $report->getMeasurements());
    }

    #[Test]
    public function canGetHeader(): void
    {
        $header = 'testHeader';

        $report = $this->getTesteeInstance(header: $header);

        self::assertSame($header, $report->getHeader());
    }

    #[Test]
    public function canGetPrefix(): void
    {
        $prefix = 'testPrefix';

        $report = $this->getTesteeInstance(prefix: $prefix);

        self::assertSame($prefix, $report->getPrefix());
    }
}
