<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Stopwatch\Factory;

use AlecRabbit\Stopwatch\Contract\Factory\IReportFactory;
use AlecRabbit\Stopwatch\Contract\IMeasurement;
use AlecRabbit\Stopwatch\Contract\IMeasurementFormatter;
use AlecRabbit\Stopwatch\Contract\IStopwatch;
use AlecRabbit\Stopwatch\Factory\StopwatchReportFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StopwatchReportFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StopwatchReportFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IStopwatch $stopwatch = null,
        ?IMeasurementFormatter $measurementFormatter = null,
        ?string $title = null,
    ): IReportFactory {
        return
            new StopwatchReportFactory(
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
                    'a1' => $this->getMeasurementMock(),
                    'a2' => $this->getMeasurementMock(),
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

        self::assertSame(
            '
testTitle (Required data points: 0):
A1: 1 (Data points: 0)
A2: 2 (Data points: 0)

',
            $factory->report()
        );
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }

}
