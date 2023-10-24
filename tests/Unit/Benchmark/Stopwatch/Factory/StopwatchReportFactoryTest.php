<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch\Factory;

use AlecRabbit\Benchmark\Contract\Factory\ILegacyReportFactory;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Contract\IResultFormatter;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Stopwatch\Factory\StopwatchLegacyReportFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StopwatchReportFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StopwatchLegacyReportFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IStopwatch $stopwatch = null,
        ?IResultFormatter $measurementFormatter = null,
        ?string $title = null,
    ): ILegacyReportFactory {
        return
            new StopwatchLegacyReportFactory(
                stopwatch: $stopwatch ?? $this->getStopwatchMock(),
                measurementFormatter: $measurementFormatter ?? $this->getMeasurementFormatterMock(),
                title: $title ?? 'Default Title',
            );
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }

    private function getMeasurementFormatterMock(): MockObject&IResultFormatter
    {
        return $this->createMock(IResultFormatter::class);
    }

    #[Test]
    public function canReport(): void
    {
        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects($this->once())
            ->method('getMeasurements')
            ->willReturn(
                new \ArrayObject(
                    [
                        'a1' => $this->getResultMock(),
                        'a2' => $this->getResultMock(),
                    ]
                )
            )
        ;

        $measurementFormatter = $this->getMeasurementFormatterMock();
        $measurementFormatter
            ->expects($this->exactly(2))
            ->method('format')
            ->with(self::isInstanceOf(IResult::class))
            ->willReturnOnConsecutiveCalls('1', '2')
        ;

        $factory = $this->getTesteeInstance(
            stopwatch: $stopwatch,
            measurementFormatter: $measurementFormatter,
            title: 'testTitle',
        );

        self::assertSame(
            '
testTitle:
A1: 1 (Data points: 0)
A2: 2 (Data points: 0)
',
            $factory->report()
        );
    }

    private function getResultMock(): MockObject&IResult
    {
        return $this->createMock(IResult::class);
    }

}
