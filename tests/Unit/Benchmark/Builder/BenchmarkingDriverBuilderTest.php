<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Builder;

use AlecRabbit\Benchmark\BenchmarkingDriver;
use AlecRabbit\Benchmark\Builder\BenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Stopwatch\Contract\IStopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkingDriverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkingDriverBuilder::class, $driverBuilder);
    }

    public function getTesteeInstance(): IBenchmarkingDriverBuilder
    {
        return
            new BenchmarkingDriverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withDriver($this->getDriverMock())
            ->withStopwatch($this->getStopwatchMock())
            ->build()
        ;

        self::assertInstanceOf(BenchmarkingDriver::class, $driver);
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
    public function throwsIfDriverIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Driver is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withStopwatch($this->getStopwatchMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfStopwatchIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Stopwatch is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriver($this->getDriverMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
