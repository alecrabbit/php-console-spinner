<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\ReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IKeyFormatter;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\ReportPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ReportPrinterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ReportPrinterBuilder::class, $printerBuilder);
    }

    private function getTesteeInstance(): IReportPrinterBuilder
    {
        return
            new ReportPrinterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $printer =
            $printerBuilder
                ->withOutput($this->getOutputMock())
                ->withReportFormatter($this->getReportFormatterMock())
                ->build()
        ;

        self::assertInstanceOf(ReportPrinter::class, $printer);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
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

    #[Test]
    public function throwsIfOutputIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Output is not set.');

        $printerBuilder
            ->withReportFormatter($this->getReportFormatterMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfReportFormatterIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Report formatter is not set.');

        $printerBuilder
            ->withOutput($this->getOutputMock())
            ->build()
        ;
    }


    private function getReportFormatterMock(): MockObject&IReportFormatter
    {
        return $this->createMock(IReportFormatter::class);
    }
}
