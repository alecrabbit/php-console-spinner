<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\ReportBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ReportBuilder::class, $reportBuilder);
    }

    private function getTesteeInstance(): IReportBuilder
    {
        return
            new ReportBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $header = 'testHeader';
        $measurements = $this->getMeasurementsMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('getMeasurements')
            ->willReturn($measurements)
        ;

        $reportBuilder = $this->getTesteeInstance();
        $report =
            $reportBuilder
                ->withBenchmark($benchmark)
                ->withTitle($header)
                ->build()
        ;
        self::assertSame($measurements, $report->getMeasurements());
        self::assertSame($header, $report->getHeader());
    }

    private function getMeasurementsMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    private function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    #[Test]
    public function throwsIfHeaderIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Title is not set');

        $reportBuilder
            ->withBenchmark($this->getBenchmarkMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfBenchmarkIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Benchmark is not set');

        $reportBuilder
            ->withTitle('testHeader')
            ->build()
        ;
    }

}
