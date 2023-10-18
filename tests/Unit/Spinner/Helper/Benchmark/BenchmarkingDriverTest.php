<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Helper\Benchmark;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Helper\Benchmark\BenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Helper\Benchmark\Contract\IStopwatch;
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
}
