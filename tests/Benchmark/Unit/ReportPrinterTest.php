<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
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
        ?IReportFormatter $reportFormatter = null,
    ): IReportPrinter {
        return
            new ReportPrinter(
                output: $output ?? $this->getOutputMock(),
                reportFormatter: $reportFormatter ?? $this->getReportFormatterMock(),
            );
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
    public function canPrint(): void
    {
        $report = $this->getReportMock();

        $expectedOutput = 'Benchmark Report';

        $reportFormatter = $this->getReportFormatterMock();
        $reportFormatter
            ->expects(self::once())
            ->method('format')
            ->with($report)
            ->willReturn($expectedOutput)
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
            reportFormatter: $reportFormatter,
        );

        $printer->print($report);
    }

    protected function getReportMock(): MockObject&IReport
    {
        return $this->createMock(IReport::class);
    }

    private function getResultFormatterMock(): MockObject&IResultFormatter
    {
        return $this->createMock(IResultFormatter::class);
    }

    private function getKeyFormatterMock(): MockObject&IKeyFormatter
    {
        return $this->createMock(IKeyFormatter::class);
    }

    private function getResultMock(): MockObject&IResult
    {
        return $this->createMock(IResult::class);
    }

    private function getDatetimeFormatterMock(): MockObject&IDatetimeFormatter
    {
        return $this->createMock(IDatetimeFormatter::class);
    }
}
