<?php

declare(strict_types=1);

namespace Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\MeasurementShortFormatter;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MeasurementShortFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(MeasurementShortFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IMeasurementFormatter
    {
        return
            new MeasurementShortFormatter();
    }

    #[Test]
    public function canFormatWithAverage(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock(
                unit: TimeUnit::MICROSECOND
            );

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willReturn(1.0)
        ;

        self::assertEquals('1.00μs', $formatter->format($measurement));
    }    #[Test]
    public function canFormatWithoutAverage(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock(
                unit: TimeUnit::MICROSECOND
            );

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new LogicException(''))
        ;

        self::assertEquals('--', $formatter->format($measurement));
    }

    private function getMeasurementMock(?TimeUnit $unit = null): MockObject&IMeasurement
    {
        return $this->createConfiguredMock(
            IMeasurement::class,
            [
                'getUnit' => $unit ?? TimeUnit::HOUR,
            ]
        );
    }
}
