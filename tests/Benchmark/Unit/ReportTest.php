<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit;

use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Report;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class ReportTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $report = $this->getTesteeInstance();

        self::assertInstanceOf(Report::class, $report);
    }

    private function getTesteeInstance(
        ?IBenchmarkResults $benchmarkResults = null,
        ?string $title = null,
        ?string $prefix = null,
    ): IReport {
        return
            new Report(
                benchmarkResults: $benchmarkResults ?? $this->getBenchmarkResultsMock(),
                title: $title ?? $this->getFaker()->word(),
                prefix: $prefix ?? $this->getFaker()->word(),
            );
    }

    private function getBenchmarkResultsMock(): MockObject&IBenchmarkResults
    {
        return $this->createMock(IBenchmarkResults::class);
    }

    #[Test]
    public function canGetMeasurements(): void
    {
        $results = $this->getMeasurementsMock();

        $benchmarkResults = $this->getBenchmarkResultsMock();

        $benchmarkResults
            ->expects(self::once())
            ->method('getResults')
            ->willReturn($results)
        ;

        $report = $this->getTesteeInstance(
            benchmarkResults: $benchmarkResults
        );

        self::assertSame($results, $report->getResults());
    }

    private function getMeasurementsMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function canGetHeader(): void
    {
        $header = 'testHeader';

        $report = $this->getTesteeInstance(title: $header);

        self::assertSame($header, $report->getTitle());
    }

    #[Test]
    public function canGetPrefix(): void
    {
        $prefix = 'testPrefix';

        $report = $this->getTesteeInstance(
            prefix: $prefix,
        );

        self::assertSame($prefix, $report->getPrefix());
    }
}
