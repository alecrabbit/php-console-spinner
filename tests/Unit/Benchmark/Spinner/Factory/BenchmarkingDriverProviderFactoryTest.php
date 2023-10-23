<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Spinner\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Benchmark\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
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
        ?IDriverLinker $driverLinker = null,
        ?IBenchmarkingDriverFactory $benchmarkingDriverFactory = null,
    ): IDriverProviderFactory {
        return
            new BenchmarkingDriverProviderFactory(
                benchmarkingDriverFactory: $benchmarkingDriverFactory ?? $this->getBenchmarkingDriverFactoryMock(),
                driverLinker: $driverLinker ?? $this->getDriverLinkerMock(),
            );
    }

    private function getBenchmarkingDriverFactoryMock(): MockObject&IBenchmarkingDriverFactory
    {
        return $this->createMock(IBenchmarkingDriverFactory::class);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $benchmarkingDriver = $this->getBenchmarkingDriverMock();
        $benchmarkingDriver
            ->expects(self::once())
            ->method('initialize')
        ;

        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::once())
            ->method('link')
            ->with(self::identicalTo($benchmarkingDriver))
        ;

        $benchmarkingDriverFactory = $this->getBenchmarkingDriverFactoryMock();
        $benchmarkingDriverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($benchmarkingDriver)
        ;

        $factory =
            $this->getTesteeInstance(
                driverLinker: $driverLinker,
                benchmarkingDriverFactory: $benchmarkingDriverFactory,
            );

        $driverProvider = $factory->create();

        self::assertSame($benchmarkingDriver, $driverProvider->getDriver());
    }

    protected function getBenchmarkingDriverMock(): MockObject&IBenchmarkingDriver
    {
        return $this->createMock(IBenchmarkingDriver::class);
    }

    protected function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getBenchmarkFactoryMock(): MockObject&IBenchmarkFactory
    {
        return $this->createMock(IBenchmarkFactory::class);
    }

    private function getDriverFactoryMock(): MockObject&IDriverFactory
    {
        return $this->createMock(IDriverFactory::class);
    }

    private function getBenchmarkingDriverBuilderMock(): MockObject&IBenchmarkingDriverBuilder
    {
        return $this->createMock(IBenchmarkingDriverBuilder::class);
    }
}
