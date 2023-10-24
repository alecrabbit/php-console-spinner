<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch\Stopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

final class StopwatchTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(Stopwatch::class, $measurement);
    }

    private function getTesteeInstance(
        ?ITimer $timer = null,
        ?IMeasurementFactory $factory = null,
    ): IStopwatch {
        return
            new Stopwatch(
                timer: $timer ?? $this->getTimerMock(),
                measurementFactory: $factory ?? $this->getMeasurementFactoryMock(),
            );
    }

    private function getTimerMock(?TimeUnit $unit = null): MockObject&ITimer
    {
        return $this->createConfiguredMock(
            ITimer::class,
            [
                'getUnit' => $unit ?? TimeUnit::HOUR,
            ]
        );
    }

    private function getMeasurementFactoryMock(): MockObject&IMeasurementFactory
    {
        return $this->createMock(IMeasurementFactory::class);
    }

    #[Test]
    public function canGetUnit(): void
    {
        $unit = TimeUnit::MICROSECOND;

        $timer = $this->getTimerMock($unit);
        $timer
            ->expects(self::once())
            ->method('getUnit')
            ->willReturn($unit)
        ;

        $stopwatch = $this->getTesteeInstance(
            timer: $timer,
        );

        self::assertEquals($unit, $stopwatch->getUnit());
    }

    #[Test]
    public function canStart(): void
    {
        $key = 'testLabel';

        $timer = $this->getTimerMock();
        $value = 1.0;
        $timer
            ->expects(self::once())
            ->method('now')
            ->willReturn($value)
        ;

        $stopwatch = $this->getTesteeInstance(
            timer: $timer,
        );

        $stopwatch->start($key);

        $current = self::getPropertyValue('current', $stopwatch);

        self::assertArrayHasKey($key, $current);
        self::assertSame($value, $current[$key]);
    }

    #[Test]
    public function canStop(): void
    {
        $key = 'testLabel';

        $timer = $this->getTimerMock();

        $valueStart = 1.0;
        $valueStop = $valueStart + 1.0;

        $timer
            ->expects(self::exactly(2))
            ->method('now')
            ->willReturnOnConsecutiveCalls($valueStart, $valueStop)
        ;

        $stopwatch = $this->getTesteeInstance(
            timer: $timer,
        );

        $stopwatch->start($key);

        $current = self::getPropertyValue('current', $stopwatch);

        self::assertArrayHasKey($key, $current);
        self::assertSame($valueStart, $current[$key]);

        $stopwatch->stop($key);

        $current = self::getPropertyValue('current', $stopwatch);
        self::assertArrayNotHasKey($key, $current);

        $measurements = iterator_to_array($stopwatch->getMeasurements());

        self::assertArrayHasKey($key, $measurements);
        self::assertCount(1, $measurements);
    }

    #[Test]
    public function throwsIfAlreadyStarted(): void
    {
        $label = 'testLabel';

        $stopwatch = $this->getTesteeInstance();

        $stopwatch->start($label);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Already started.');

        $stopwatch->start($label);
    }
}
