<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
        ?int $threshold = null,
    ): IStopwatch {
        return
            new Stopwatch(
                timer: $timer ?? $this->getTimerMock(),
                requiredMeasurements: $threshold ?? 0,
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

    #[Test]
    public function canGetRequiredMeasurements(): void
    {
        $threshold = 2;

        $stopwatch = $this->getTesteeInstance(threshold: $threshold);

        self::assertSame($threshold, $stopwatch->getRequiredMeasurements());
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
}
