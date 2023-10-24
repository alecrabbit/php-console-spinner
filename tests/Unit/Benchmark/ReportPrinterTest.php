<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\ReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportPrinterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $printer = $this->getTesteeInstance();

        self::assertInstanceOf(ReportPrinter::class, $printer);
    }

    private function getTesteeInstance(
        ?IOutput $output = null,
        ?IDatetimeFormatter $datetimeFormatter = null,
        ?IMeasurementFormatter $measurementFormatter = null,
        ?IKeyFormatter $measurementKeyFormatter = null,
    ): IReportPrinter {
        return
            new ReportPrinter(
                output: $output ?? $this->getOutputMock(),
                datetimeFormatter: $datetimeFormatter ?? $this->getDatetimeFormatterMock(),
                measurementFormatter: $measurementFormatter ?? $this->getMeasurementFormatterMock(),
                measurementKeyFormatter: $measurementKeyFormatter ?? $this->getMeasurementKeyFormatterMock(),
            );
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
    public function canPrint(): void
    {
        $report = $this->getReportMock();
        $report
            ->expects(self::once())
            ->method('getHeader')
            ->willReturn('testHeader')
        ;
        $prefix = "testPrefix";
        $report
            ->expects(self::exactly(2))
            ->method('getPrefix')
            ->willReturn($prefix)
        ;

        $count = 1;
        $value = 'M';
        $measurement = $this->getMeasurementMock();
        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn($count)
        ;

        $key = 'testKey';
        $report
            ->expects(self::once())
            ->method('getMeasurements')
            ->willReturn(
                [$key => $measurement],
            )
        ;

        $datetimeFormatter = $this->getDatetimeFormatterMock();
        $datetimeFormatter
            ->expects(self::once())
            ->method('format')
            ->willReturn('testDatetime')
        ;

        $expectedOutput = <<<HEADER
                Benchmark Report
                testHeader
                Date: testDatetime

                {$prefix}
                {$key}[{$count}]: {$value}

                HEADER;

        $measurementFormatter = $this->getMeasurementFormatterMock();
        $measurementFormatter
            ->expects(self::once())
            ->method('format')
            ->with($measurement)
            ->willReturn($value)
        ;

        $measurementKeyFormatter = $this->getMeasurementKeyFormatterMock();
        $measurementKeyFormatter
            ->expects(self::once())
            ->method('format')
            ->with($key, $prefix)
            ->willReturn($key)
        ;

        $output = $this->getOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(
                $expectedOutput
            )
        ;

        $printer = $this->getTesteeInstance(
            output: $output,
            datetimeFormatter: $datetimeFormatter,
            measurementFormatter: $measurementFormatter,
            measurementKeyFormatter: $measurementKeyFormatter,
        );

        $printer->print($report);
    }

    protected function getReportMock(): MockObject&IReport
    {
        return $this->createMock(IReport::class);
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }
}
