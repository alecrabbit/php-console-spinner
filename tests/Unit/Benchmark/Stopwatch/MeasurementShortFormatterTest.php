<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IMeasurementFormatter;
use AlecRabbit\Benchmark\Stopwatch\MeasurementShortFormatter;
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
            $this->getMeasurementMock();

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willReturn(1.0)
        ;

        self::assertEquals('1.00μs', $formatter->format($measurement));
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }

    #[Test]
    public function canFormatWithoutAverage(): void
    {
        $formatter = $this->getTesteeInstance();

        $measurement =
            $this->getMeasurementMock();

        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new LogicException(''))
        ;

        self::assertEquals('--', $formatter->format($measurement));
    }
}
