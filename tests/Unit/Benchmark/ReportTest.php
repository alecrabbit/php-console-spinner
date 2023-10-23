<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IBenchmark;
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
        ?IBenchmark $benchmark = null,
        ?string $header = null,
    ): IReport {
        return
            new Report(
                benchmark: $benchmark ?? $this->getBenchmarkMock(),
                header: $header ?? '--header--',
            );
    }

    private function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    #[Test]
    public function canGetMeasurements(): void
    {
        $measurements = $this->getMeasurementsMock();

        $benchmark = $this->getBenchmarkMock();

        $benchmark
            ->expects(self::once())
            ->method('getMeasurements')
            ->willReturn($measurements)
        ;

        $report = $this->getTesteeInstance(
            benchmark: $benchmark
        );

        self::assertSame($measurements, $report->getMeasurements());
    }

    private function getMeasurementsMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
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

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('getPrefix')
            ->willReturn($prefix)
        ;

        $report = $this->getTesteeInstance(
            benchmark: $benchmark,
        );

        self::assertSame($prefix, $report->getPrefix());
    }
}
