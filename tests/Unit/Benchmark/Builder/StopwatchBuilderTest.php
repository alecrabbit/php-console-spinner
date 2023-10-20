<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IMeasurementFactory;
use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Stopwatch\Stopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StopwatchBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(StopwatchBuilder::class, $builder);
    }

    private function getTesteeInstance(): IStopwatchBuilder
    {
        return new StopwatchBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $stopwatch =
            $builder
                ->withTimer($this->getTimerMock())
                ->withMeasurementFactory($this->getMeasurementFactoryMock())
                ->build()
        ;

        self::assertInstanceOf(Stopwatch::class, $stopwatch);
    }

    private function getTimerMock(): MockObject&ITimer
    {
        return $this->createMock(ITimer::class);
    }

    private function getMeasurementFactoryMock(): MockObject&IMeasurementFactory
    {
        return $this->createMock(IMeasurementFactory::class);
    }

    #[Test]
    public function throwsIfTimerIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Timer is not set.');

        $builder->build();
    }

    #[Test]
    public function throwsIfMeasurementFactoryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Measurement factory is not set.');

        $builder
            ->withTimer($this->getTimerMock())
            ->build()
        ;
    }
}
