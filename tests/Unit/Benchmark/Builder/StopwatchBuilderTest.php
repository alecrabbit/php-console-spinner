<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\Builder\StopwatchBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IStopwatchBuilder;
use AlecRabbit\Benchmark\Contract\IMeasurement;
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
                ->withMeasurementSpawner(
                    $this->getSpawner()
                )
                ->build()
        ;

        self::assertInstanceOf(Stopwatch::class, $stopwatch);
    }

    private function getTimerMock(): MockObject&ITimer
    {
        return $this->createMock(ITimer::class);
    }

    protected function getSpawner(): \Closure
    {
        return function (): IMeasurement {
            return $this->createMock(IMeasurement::class);
        };
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
    public function throwsIfSpawnerIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Measurement spawner is not set.');

        $builder
            ->withTimer($this->getTimerMock())
            ->build()
        ;
    }

    #[Test]
    public function throwsIfSpawnerIsThrowing(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Measurement spawner invocation throws: Test.');

        $builder
            ->withTimer($this->getTimerMock())
            ->withMeasurementSpawner(
                function (): string {
                    throw new \RuntimeException('Test');
                }
            )
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }
    #[Test]
    public function throwsIfSpawnerHasNoReturnType(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Return type of time function is not specified.');

        $builder
            ->withTimer($this->getTimerMock())
            ->withMeasurementSpawner(
                function () {
                    return null;
                }
            )
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }
}
