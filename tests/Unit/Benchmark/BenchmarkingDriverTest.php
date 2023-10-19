<?php

declare(strict_types=1);

namespace Unit\Benchmark;

use AlecRabbit\Benchmark\BenchmarkingDriver;
use AlecRabbit\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkingDriverTest extends TestCase
{

    #[Test]
    public function canBeInstantiated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkingDriver::class, $driver);
    }

    private function getTesteeInstance(
        ?IDriver $driver = null,
        ?IStopwatch $stopwatch = null,
    ): IBenchmarkingDriver {
        return
            new BenchmarkingDriver(
                driver: $driver ?? $this->getDriverMock(),
                stopwatch: $stopwatch ?? $this->getStopwatchMock(),
            );
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }

    #[Test]
    public function createdWithDefinedShortName(): void
    {
        $driver = $this->getTesteeInstance();

        $value = 'BenchmarkingDriver';

        self::assertSame(
            self::getPropertyValue('shortName', $driver),
            $value,
        );
    }

    #[Test]
    public function canCreateLabel(): void
    {
        $driver = $this->getTesteeInstance();

        $shortName = 'BenchmarkingDriver';
        $function = 'function';

        self::assertSame(
            self::callMethod($driver, 'createLabel', $function),
            $shortName . '::' . $function . '()',
        );
    }

    #[Test]
    public function canGetStopwatch(): void
    {
        $stopwatch = $this->getStopwatchMock();

        $driver =
            $this->getTesteeInstance(
                stopwatch: $stopwatch
            );

        self::assertSame($stopwatch, $driver->getStopwatch(),);
    }

    #[Test]
    public function canRender(): void
    {
        $dt = 100.0;
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('render')
            ->with(self::identicalTo($dt))
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        $benchmarkingDriver->render($dt);
    }
}
