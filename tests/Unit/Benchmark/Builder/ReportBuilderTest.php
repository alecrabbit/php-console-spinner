<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\ReportBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportBuilder;
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
        $reportBuilder = $this->getTesteeInstance();
        $measurements = $this->getMeasurementsMock();
        $header = 'testHeader';
        $prefix = 'testPrefix';
        $report =
            $reportBuilder
                ->withMeasurements($measurements)
                ->withHeader($header)
                ->withPrefix($prefix)
                ->build()
        ;
        self::assertSame($measurements, $report->getMeasurements());
        self::assertSame($header, $report->getHeader());
        self::assertSame($prefix, $report->getPrefix());
    }

    private function getMeasurementsMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    #[Test]
    public function throwsIfHeaderIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $measurements = $this->getMeasurementsMock();
        $prefix = 'testPrefix';

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Header is not set');
        $reportBuilder
            ->withMeasurements($measurements)
            ->withPrefix($prefix)
            ->build()
        ;
    }

    #[Test]
    public function throwsIfPrefixIsNotSet(): void
    {
        $reportBuilder = $this->getTesteeInstance();

        $measurements = $this->getMeasurementsMock();
        $header = 'testHeader';

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Prefix is not set');
        $reportBuilder
            ->withMeasurements($measurements)
            ->withHeader($header)
            ->build()
        ;
    }
}
