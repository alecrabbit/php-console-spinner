<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\ReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\IDatetimeFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IMeasurementKeyFormatter;
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
                ->withDatetimeFormatter($this->getDatetimeFormatterMock())
                ->withMeasurementFormatter($this->getMeasurementFormatterMock())
                ->withMeasurementKeyFormatter($this->getMeasurementKeyFormatterMock())
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

    private function getMeasurementFormatterMock(): MockObject&IMeasurementFormatter
    {
        return $this->createMock(IMeasurementFormatter::class);
    }

    private function getMeasurementKeyFormatterMock(): MockObject&IMeasurementKeyFormatter
    {
        return $this->createMock(IMeasurementKeyFormatter::class);
    }

    #[Test]
    public function throwsIfOutputIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Output is not set.');

        $printerBuilder
            ->withDatetimeFormatter($this->getDatetimeFormatterMock())
            ->withMeasurementFormatter($this->getMeasurementFormatterMock())
            ->withMeasurementKeyFormatter($this->getMeasurementKeyFormatterMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfDatetimeFormatterIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Datetime formatter is not set.');

        $printerBuilder
            ->withOutput($this->getOutputMock())
            ->withMeasurementFormatter($this->getMeasurementFormatterMock())
            ->withMeasurementKeyFormatter($this->getMeasurementKeyFormatterMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfMeasurementFormatterIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Measurement formatter is not set.');

        $printerBuilder
            ->withOutput($this->getOutputMock())
            ->withDatetimeFormatter($this->getDatetimeFormatterMock())
            ->withMeasurementKeyFormatter($this->getMeasurementKeyFormatterMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfMeasurementKeyFormatterIsNotSet(): void
    {
        $printerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Measurement key formatter is not set.');

        $printerBuilder
            ->withOutput($this->getOutputMock())
            ->withDatetimeFormatter($this->getDatetimeFormatterMock())
            ->withMeasurementFormatter($this->getMeasurementFormatterMock())
            ->build()
        ;
    }
}
