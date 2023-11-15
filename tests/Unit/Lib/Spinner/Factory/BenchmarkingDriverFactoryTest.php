<?php

declare(strict_types=1);

namespace Unit\Lib\Spinner\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Lib\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Lib\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Lib\Spinner\Factory\BenchmarkingDriverFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkingDriverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkingDriverFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverFactory $driverFactory = null,
        ?IBenchmarkingDriverBuilder $benchmarkingDriverBuilder = null,
        ?IBenchmarkFactory $benchmarkFactory = null,
    ): IBenchmarkingDriverFactory {
        return
            new BenchmarkingDriverFactory(
                benchmarkingDriverBuilder: $benchmarkingDriverBuilder ?? $this->getBenchmarkingDriverBuilderMock(),
                benchmarkFactory: $benchmarkFactory ?? $this->getBenchmarkFactoryMock(),
                driverFactory: $driverFactory ?? $this->getDriverFactoryMock(),
            );
    }

    private function getBenchmarkingDriverBuilderMock(): MockObject&IBenchmarkingDriverBuilder
    {
        return $this->createMock(IBenchmarkingDriverBuilder::class);
    }

    private function getBenchmarkFactoryMock(): MockObject&IBenchmarkFactory
    {
        return $this->createMock(IBenchmarkFactory::class);
    }

    private function getDriverFactoryMock(): MockObject&IDriverFactory
    {
        return $this->createMock(IDriverFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $benchmark = $this->getBenchmarkMock();

        $benchmarkFactory = $this->getBenchmarkFactoryMock();
        $benchmarkFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($benchmark)
        ;

        $benchmarkingDriver = $this->getBenchmarkingDriverMock();

        $driver = $this->getDriverMock();

        $driverFactory = $this->getDriverFactoryMock();
        $driverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driver)
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
            ->method('withBenchmark')
            ->with(self::identicalTo($benchmark))
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
                benchmarkingDriverBuilder: $driverBuilder,
                benchmarkFactory: $benchmarkFactory,
            );

        $driver = $factory->create();

        self::assertSame($benchmarkingDriver, $driver);
    }

    protected function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    protected function getBenchmarkingDriverMock(): MockObject&IBenchmarkingDriver
    {
        return $this->createMock(IBenchmarkingDriver::class);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }
}
