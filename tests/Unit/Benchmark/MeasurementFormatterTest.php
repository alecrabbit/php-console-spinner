<?php

declare(strict_types=1);

namespace Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\MeasurementFormatter;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MeasurementFormatterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(MeasurementFormatter::class, $formatter);
    }

    private function getTesteeInstance(): IMeasurementFormatter
    {
        return
            new MeasurementFormatter();
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
        $measurement
            ->expects(self::once())
            ->method('getMax')
            ->willReturn(1.0)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMin')
            ->willReturn(1.0)
        ;

        self::assertEquals('1.00μs [1.00μs/1.00μs]', $formatter->format($measurement));
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

    #[Test]
    public function canFormatWithoutAverageAndWithoutAny(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock(
                unit: TimeUnit::MICROSECOND
            );

        $str = 'Exception.';

        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn(0)
        ;

        $measurement
            ->expects(self::once())
            ->method('getAny')
            ->willThrowException(new LogicException($str))
        ;

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new LogicException($str))
        ;

        self::assertEquals($str, $formatter->format($measurement));
    }

    #[Test]
    public function canFormatWithoutAverageButWithAny(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock(
                unit: TimeUnit::MICROSECOND
            );

        $str = 'Exception.';

        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn(0)
        ;

        $measurement
            ->expects(self::once())
            ->method('getAny')
            ->willReturn(2.0)
        ;

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new LogicException($str))
        ;

        self::assertEquals('2.00μs', $formatter->format($measurement));
    }

    #[Test]
    public function canFormatWithoutAverageButWithAnyAndMinMax(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock(
                unit: TimeUnit::MICROSECOND
            );

        $str = 'Exception.';

        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn(3)
        ;

        $measurement
            ->expects(self::once())
            ->method('getAny')
            ->willReturn(2.0)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMin')
            ->willReturn(1.0)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMax')
            ->willReturn(3.0)
        ;

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new LogicException($str))
        ;

        self::assertEquals('2.00μs [3.00μs/1.00μs]', $formatter->format($measurement));
    }
}
