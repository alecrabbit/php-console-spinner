<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Benchmark\Unit\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Exception\MeasurementException;
use AlecRabbit\Benchmark\Factory\ResultMaker;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ResultMakerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $maker = $this->getTesteeInstance();

        self::assertInstanceOf(ResultMaker::class, $maker);
    }

    private function getTesteeInstance(): IResultMaker
    {
        return new ResultMaker();
    }

    #[Test]
    public function canMake(): void
    {
        $average = 1.1;
        $min = 0.3;
        $max = 2.3;
        $count = 13;

        $maker = $this->getTesteeInstance();

        $measurement = $this->getMeasurementMock();
        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willReturn($average)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMin')
            ->willReturn($min)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMax')
            ->willReturn($max)
        ;
        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn($count)
        ;

        $result = $maker->make($measurement);

        self::assertSame($average, $result->getAverage());
        self::assertSame($min, $result->getMin());
        self::assertSame($max, $result->getMax());
        self::assertSame($count, $result->getCount());
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }

    #[Test]
    public function canMakeWithException(): void
    {
        $any = 0.3;
        $min = 0.3;
        $max = 0.3;
        $count = 1;

        $maker = $this->getTesteeInstance();

        $measurement = $this->getMeasurementMock();
        $measurement
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new MeasurementException())
        ;
        $measurement
            ->expects(self::once())
            ->method('getAny')
            ->willReturn($any)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMin')
            ->willReturn($min)
        ;
        $measurement
            ->expects(self::once())
            ->method('getMax')
            ->willReturn($max)
        ;
        $measurement
            ->expects(self::once())
            ->method('getCount')
            ->willReturn($count)
        ;

        $result = $maker->make($measurement);

        self::assertSame($any, $result->getAverage());
        self::assertSame($min, $result->getMin());
        self::assertSame($max, $result->getMax());
        self::assertSame($count, $result->getCount());
    }
}
