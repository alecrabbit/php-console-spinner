<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;


use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
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
        ?IBenchmark $benchmark = null,
        ?IReportBuilder $reportBuilder = null,
        ?string $title = null,
    ): IReportFactory {
        return
            new ReportFactory(
                benchmark: $benchmark ?? $this->getBenchmarkMock(),
                title: $title ?? '--title--',
                reportBuilder: $reportBuilder ?? $this->getReportBuilderMock(),
            );
    }

    private function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    private function getReportBuilderMock(): MockObject&IReportBuilder
    {
        return $this->createMock(IReportBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $header = 'testHeader';
        $benchmark = $this->getBenchmarkMock();

        $report = $this->getReportMock();

        $reportBuilder = $this->getReportBuilderMock();
        $reportBuilder
            ->expects(self::once())
            ->method('withBenchmark')
            ->with($benchmark)
            ->willReturnSelf()
        ;
        $reportBuilder
            ->expects(self::once())
            ->method('withTitle')
            ->with($header)
            ->willReturnSelf()
        ;

        $reportBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($report)
        ;

        $factory = $this->getTesteeInstance(
            benchmark: $benchmark,
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
}
