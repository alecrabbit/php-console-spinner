<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Benchmark;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class BenchmarkTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurement = $this->getTesteeInstance();

        self::assertInstanceOf(Benchmark::class, $measurement);
    }

    private function getTesteeInstance(
        ?IStopwatch $stopwatch = null,
    ): IBenchmark {
        return
            new Benchmark(
                stopwatch: $stopwatch ?? $this->getStopwatchMock(),
            );
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }

    protected function extractPrefix(IBenchmark $benchmark): mixed
    {
        return self::getPropertyValue(self::PREFIX, $benchmark);
    }

    #[Test]
    public function canGetMeasurements(): void
    {
        $measurements = $this->getMeasurementsMock();

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('getMeasurements')
            ->willReturn($measurements)
        ;

        $benchmark =
            $this->getTesteeInstance(
                stopwatch: $stopwatch,
            );

        self::assertEquals($measurements, $benchmark->getMeasurements());
    }

    private function getMeasurementsMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function canRun(): void
    {
        $arg1 = 'testArg1';
        $arg2 = 'testArg2';

        $args = [$arg1, $arg2];

        $result = $arg1 . '+' . $arg2;
        $key = 'testKey';

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
            ->with($key)
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
            ->with($key)
        ;

        $benchmark =
            $this->getTesteeInstance(
                stopwatch: $stopwatch,
            );

        $callback = function (string $arg1, string $arg2): string {
            return $arg1 . '+' . $arg2;
        };

        self::assertEquals(
            $result,
            $benchmark->run($key, $callback, ...$args)
        );
    }

    #[Test]
    public function canGetStopwatch(): void
    {
        $stopwatch = $this->getStopwatchMock();

        $benchmark =
            $this->getTesteeInstance(
                stopwatch: $stopwatch,
            );

        self::assertEquals($stopwatch, $benchmark->getStopwatch());
    }

    #[Test]
    public function canRunWithoutPrefix(): void
    {
        $arg1 = 'testArg1';
        $arg2 = 'testArg2';

        $args = [$arg1, $arg2];

        $label = 'testLabel';

        $result = $arg1 . '+' . $arg2;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
            ->with($label)
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
            ->with($label)
        ;

        $benchmark =
            $this->getTesteeInstance(
                stopwatch: $stopwatch,
            );

        $callback = function (string $arg1, string $arg2): string {
            return $arg1 . '+' . $arg2;
        };

        self::assertEquals(
            $result,
            $benchmark->run($label, $callback, ...$args)
        );
    }

    private function getResultsFactoryMock(): MockObject&IBenchmarkResultsFactory
    {
        return $this->createMock(IBenchmarkResultsFactory::class);
    }
}
