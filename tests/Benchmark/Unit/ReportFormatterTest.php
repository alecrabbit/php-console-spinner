<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit;

use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReport;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\ReportFormatter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $printer = $this->getTesteeInstance();

        self::assertInstanceOf(ReportFormatter::class, $printer);
    }

    private function getTesteeInstance(
        ?IDatetimeFormatter $datetimeFormatter = null,
        ?IResultFormatter $resultFormatter = null,
        ?IKeyFormatter $keyFormatter = null,
    ): IReportFormatter {
        return
            new ReportFormatter(
                datetimeFormatter: $datetimeFormatter ?? $this->getDatetimeFormatterMock(),
                resultFormatter: $resultFormatter ?? $this->getResultFormatterMock(),
                keyFormatter: $keyFormatter ?? $this->getKeyFormatterMock(),
            );
    }

    private function getDatetimeFormatterMock(): MockObject&IDatetimeFormatter
    {
        return $this->createMock(IDatetimeFormatter::class);
    }

    private function getResultFormatterMock(): MockObject&IResultFormatter
    {
        return $this->createMock(IResultFormatter::class);
    }

    private function getKeyFormatterMock(): MockObject&IKeyFormatter
    {
        return $this->createMock(IKeyFormatter::class);
    }

    #[Test]
    public function canPrint(): void
    {
        $report = $this->getReportMock();
        $report
            ->expects(self::once())
            ->method('getTitle')
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
        $measurement = $this->getResultMock();
        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn($count)
        ;

        $key = 'testKey';
        $report
            ->expects(self::once())
            ->method('getResults')
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

                Prefix: {$prefix}
                {$key}[{$count}]: {$value}

                HEADER;

        $measurementFormatter = $this->getResultFormatterMock();
        $measurementFormatter
            ->expects(self::once())
            ->method('format')
            ->with($measurement)
            ->willReturn($value)
        ;

        $keyFormatter = $this->getKeyFormatterMock();
        $keyFormatter
            ->expects(self::once())
            ->method('format')
            ->with($key, $prefix)
            ->willReturn($key)
        ;

        $printer = $this->getTesteeInstance(
            datetimeFormatter: $datetimeFormatter,
            resultFormatter: $measurementFormatter,
            keyFormatter: $keyFormatter,
        );

        self::assertSame($expectedOutput, $printer->format($report));
    }

    protected function getReportMock(): MockObject&IReport
    {
        return $this->createMock(IReport::class);
    }

    private function getResultMock(): MockObject&IResult
    {
        return $this->createMock(IResult::class);
    }
}
