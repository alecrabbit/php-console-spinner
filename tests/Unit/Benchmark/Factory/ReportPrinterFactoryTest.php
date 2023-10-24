<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;


use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Factory\ReportPrinterFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportPrinterFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ReportPrinterFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IReportPrinterBuilder $builder = null,
        ?IOutput $output = null,
        ?IDatetimeFormatter $datetimeFormatter = null,
        ?IMeasurementFormatter $measurementFormatter = null,
        ?IKeyFormatter $measurementKeyFormatter = null,
    ): IReportPrinterFactory {
        return
            new ReportPrinterFactory(
                builder: $builder ?? $this->getReportPrinterBuilderMock(),
                output: $output ?? $this->getOutputMock(),
                datetimeFormatter: $datetimeFormatter ?? $this->getDatetimeFormatterMock(),
                measurementFormatter: $measurementFormatter ?? $this->getMeasurementFormatterMock(),
                measurementKeyFormatter: $measurementKeyFormatter ?? $this->getMeasurementKeyFormatterMock(),
            );
    }

    private function getReportPrinterBuilderMock(): MockObject&IReportPrinterBuilder
    {
        return $this->createMock(IReportPrinterBuilder::class);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    private function getDatetimeFormatterMock(): MockObject&IDatetimeFormatter
    {
        return $this->createMock(IDatetimeFormatter::class);
    }

    private function getMeasurementFormatterMock(): MockObject&IMeasurementFormatter
    {
        return $this->createMock(IMeasurementFormatter::class);
    }

    private function getMeasurementKeyFormatterMock(): MockObject&IKeyFormatter
    {
        return $this->createMock(IKeyFormatter::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $reportPrinter = $this->getReportPrinterMock();

        $output = $this->getOutputMock();
        $datetimeFormatter = $this->getDatetimeFormatterMock();
        $measurementFormatter = $this->getMeasurementFormatterMock();
        $measurementKeyFormatter = $this->getMeasurementKeyFormatterMock();
        $builder = $this->getReportPrinterBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withOutput')
            ->with($output)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withDatetimeFormatter')
            ->with($datetimeFormatter)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withMeasurementFormatter')
            ->with($measurementFormatter)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withMeasurementKeyFormatter')
            ->with($measurementKeyFormatter)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($reportPrinter)
        ;


        $factory = $this->getTesteeInstance(
            builder: $builder,
            output: $output,
            datetimeFormatter: $datetimeFormatter,
            measurementFormatter: $measurementFormatter,
            measurementKeyFormatter: $measurementKeyFormatter,
        );

        $printer = $factory->create();

        self::assertSame($reportPrinter, $printer);
    }

    private function getReportPrinterMock(): MockObject&IReportPrinter
    {
        return $this->createMock(IReportPrinter::class);
    }
}
