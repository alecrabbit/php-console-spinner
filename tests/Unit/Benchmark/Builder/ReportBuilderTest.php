<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\ReportBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IBenchmarkResults;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

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
        $title = 'testHeader';
        $results = $this->getResultsMock();
        $benchmarkResults = $this->getBenchmarkResultsMock();
        $benchmarkResults
            ->expects(self::once())
            ->method('getResults')
            ->willReturn($results)
        ;

        $reportBuilder = $this->getTesteeInstance();
        $report =
            $reportBuilder
                ->withTitle($title)
                ->withBenchmarkResults($benchmarkResults)
                ->build()
        ;
        self::assertSame($results, $report->getResults());
        self::assertSame($title, $report->getTitle());
    }

    private function getResultsMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getBenchmarkResultsMock(): MockObject&IBenchmarkResults
    {
        return $this->createMock(IBenchmarkResults::class);
    }

    #[Test]
    public function throwsIfTitleIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title is not set');

        $reportBuilder
            ->withBenchmarkResults($this->getBenchmarkResultsMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfBenchmarkResultsIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('BenchmarkResults is not set');

        $reportBuilder
            ->withTitle('testHeader')
            ->build()
        ;
    }
}
