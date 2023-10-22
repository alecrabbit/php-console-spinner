<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch\Factory;

use AlecRabbit\Benchmark\Contract\Factory\ILegacyReportFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Stopwatch\Factory\StopwatchShortLegacyReportFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StopwatchShortReportFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StopwatchShortLegacyReportFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IStopwatch $stopwatch = null,
        ?IMeasurementFormatter $measurementFormatter = null,
        ?string $title = null,
    ): ILegacyReportFactory {
        return
            new StopwatchShortLegacyReportFactory(
                stopwatch: $stopwatch ?? $this->getStopwatchMock(),
                measurementFormatter: $measurementFormatter ?? $this->getMeasurementFormatterMock(),
                title: $title ?? 'Default Title',
            );
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }

    private function getMeasurementFormatterMock(): MockObject&IMeasurementFormatter
    {
        return $this->createMock(IMeasurementFormatter::class);
    }

    #[Test]
    public function canReport(): void
    {
        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects($this->once())
            ->method('getMeasurements')
            ->willReturn(
                [
                    $this->getMeasurementMock(),
                    $this->getMeasurementMock(),
                ]
            )
        ;
        $measurementFormatter = $this->getMeasurementFormatterMock();
        $measurementFormatter
            ->expects($this->exactly(2))
            ->method('format')
            ->with(self::isInstanceOf(IMeasurement::class))
            ->willReturnOnConsecutiveCalls('1', '2')
        ;

        $factory = $this->getTesteeInstance(
            stopwatch: $stopwatch,
            measurementFormatter: $measurementFormatter,
            title: 'testTitle',
        );

        self::assertSame('testTitle: 1 2', $factory->report());
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }

}
