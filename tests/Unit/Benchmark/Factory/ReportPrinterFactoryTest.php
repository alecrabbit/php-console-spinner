<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;


use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
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
        ?IReportFormatter $reportFormatter = null,
    ): IReportPrinterFactory {
        return
            new ReportPrinterFactory(
                builder: $builder ?? $this->getReportPrinterBuilderMock(),
                output: $output ?? $this->getOutputMock(),
                reportFormatter: $reportFormatter ?? $this->getReportFormatterMock(),
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

    private function getReportFormatterMock(): MockObject&IReportFormatter
    {
        return $this->createMock(IReportFormatter::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $reportPrinter = $this->getReportPrinterMock();

        $output = $this->getOutputMock();
        $reportFormatter = $this->getReportFormatterMock();
        $builder = $this->getReportPrinterBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withOutput')
            ->with($output)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withReportFormatter')
            ->with($reportFormatter)
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
            reportFormatter: $reportFormatter,
        );

        $printer = $factory->create();

        self::assertSame($reportPrinter, $printer);
    }

    private function getReportPrinterMock(): MockObject&IReportPrinter
    {
        return $this->createMock(IReportPrinter::class);
    }

    private function getDatetimeFormatterMock(): MockObject&IDatetimeFormatter
    {
        return $this->createMock(IDatetimeFormatter::class);
    }

    private function getMeasurementFormatterMock(): MockObject&IResultFormatter
    {
        return $this->createMock(IResultFormatter::class);
    }

    private function getMeasurementKeyFormatterMock(): MockObject&IKeyFormatter
    {
        return $this->createMock(IKeyFormatter::class);
    }
}
