<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Stopwatch\Contract\Factory\IStopwatchFactory;
use AlecRabbit\Stopwatch\Contract\IStopwatch;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkingDriverProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkingDriverProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverFactory $driverFactory = null,
        ?IDriverLinker $driverLinker = null,
        ?IBenchmarkingDriverBuilder $benchmarkingDriverBuilder = null,
        ?IStopwatchFactory $stopwatchFactory = null,
    ): IDriverProviderFactory {
        return
            new BenchmarkingDriverProviderFactory(
                driverFactory: $driverFactory ?? $this->getDriverFactoryMock(),
                linker: $driverLinker ?? $this->getDriverLinkerMock(),
                benchmarkingDriverBuilder: $benchmarkingDriverBuilder ?? $this->getBenchmarkingDriverBuilderMock(),
                stopwatchFactory: $stopwatchFactory ?? $this->getStopwatchFactoryMock(),
            );
    }

    private function getDriverFactoryMock(): MockObject&IDriverFactory
    {
        return $this->createMock(IDriverFactory::class);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    private function getBenchmarkingDriverBuilderMock(): MockObject&IBenchmarkingDriverBuilder
    {
        return $this->createMock(IBenchmarkingDriverBuilder::class);
    }

    private function getStopwatchFactoryMock(): MockObject&IStopwatchFactory
    {
        return $this->createMock(IStopwatchFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $stopwatch = $this->getStopwatchMock();

        $stopwatchFactory = $this->getStopwatchFactoryMock();
        $stopwatchFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($stopwatch)
        ;

        $benchmarkingDriver = $this->getBenchmarkingDriverMock();
        $benchmarkingDriver
            ->expects(self::once())
            ->method('initialize')
        ;

        $driver = $this->getDriverMock();

        $driverFactory = $this->getDriverFactoryMock();
        $driverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driver)
        ;

        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with(self::identicalTo($benchmarkingDriver))
        ;

        $driverBuilder = $this->getBenchmarkingDriverBuilderMock();
        $driverBuilder
            ->expects(self::once())
            ->method('withDriver')
            ->with(self::identicalTo($driver))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withStopwatch')
            ->with(self::identicalTo($stopwatch))
            ->willReturnSelf()
        ;

        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($benchmarkingDriver)
        ;

        $factory =
            $this->getTesteeInstance(
                driverFactory: $driverFactory,
                driverLinker: $driverLinker,
                benchmarkingDriverBuilder: $driverBuilder,
                stopwatchFactory: $stopwatchFactory,
            );

        $driverProvider = $factory->create();

        self::assertSame($benchmarkingDriver, $driverProvider->getDriver());
    }

    protected function getBenchmarkingDriverMock(): MockObject&IBenchmarkingDriver
    {
        return $this->createMock(IBenchmarkingDriver::class);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }
}
