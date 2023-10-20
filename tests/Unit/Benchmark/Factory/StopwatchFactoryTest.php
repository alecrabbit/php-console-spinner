<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Factory\StopwatchFactory;
use AlecRabbit\Benchmark\Stopwatch\Measurement;
use AlecRabbit\Benchmark\Stopwatch\Stopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StopwatchFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StopwatchFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IStopwatchBuilder $stopwatchBuilder = null,
        ?ITimer $timer = null,
        ?IMeasurementFactory $measurementFactory = null,
    ): IStopwatchFactory {
        return
            new StopwatchFactory(
                builder: $stopwatchBuilder ?? $this->getStopwatchBuilderMock(),
                timer: $timer ?? $this->getTimerMock(),
                measurementFactory: $measurementFactory ?? $this->getMeasurementFactoryMock(),
            );
    }

    private function getStopwatchBuilderMock(): MockObject&IStopwatchBuilder
    {
        return $this->createMock(IStopwatchBuilder::class);
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
    public function canCreate(): void
    {
        $stopwatch = $this->getStopwatchMock();
        $timer = $this->getTimerMock();
        $measurementFactory = $this->getMeasurementFactoryMock();

        $builder = $this->getStopwatchBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withTimer')
            ->with($timer)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withMeasurementFactory')
            ->with($measurementFactory)
            ->willReturnSelf();
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($stopwatch)
        ;
        $factory = $this->getTesteeInstance(
            stopwatchBuilder: $builder,
        );

        self::assertInstanceOf(StopwatchFactory::class, $factory);
        self::assertEquals($stopwatch, $factory->create());
    }

    protected function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }
}
