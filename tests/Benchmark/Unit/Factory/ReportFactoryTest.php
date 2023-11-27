<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit\Factory;


use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ReportFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IBenchmarkResults $benchmarkResults = null,
        ?IReportBuilder $reportBuilder = null,
        ?string $title = null,
    ): IReportFactory {
        return
            new ReportFactory(
                benchmarkResults: $benchmarkResults ?? $this->getBenchmarkResultsMock(),
                title: $title ?? $this->getFaker()->word(),
                reportBuilder: $reportBuilder ?? $this->getReportBuilderMock(),
            );
    }

    private function getBenchmarkResultsMock(): MockObject&IBenchmarkResults
    {
        return $this->createMock(IBenchmarkResults::class);
    }

    private function getReportBuilderMock(): MockObject&IReportBuilder
    {
        return $this->createMock(IReportBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $header = 'testHeader';
        $benchmarkResults = $this->getBenchmarkResultsMock();

        $report = $this->getReportMock();

        $reportBuilder = $this->getReportBuilderMock();
        $reportBuilder
            ->expects(self::once())
            ->method('withTitle')
            ->with($header)
            ->willReturnSelf()
        ;
        $reportBuilder
            ->expects(self::once())
            ->method('withBenchmarkResults')
            ->with($benchmarkResults)
            ->willReturnSelf()
        ;

        $reportBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($report)
        ;

        $factory = $this->getTesteeInstance(
            benchmarkResults: $benchmarkResults,
            reportBuilder: $reportBuilder,
            title: $header,
        );

        $report = $factory->create();

        self::assertSame($report, $report);
    }

    private function getReportMock(): MockObject&IReport
    {
        return $this->createMock(IReport::class);
    }

    private function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }
}
