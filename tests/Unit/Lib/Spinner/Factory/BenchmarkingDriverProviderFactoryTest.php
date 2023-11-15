<?php

declare(strict_types=1);

namespace Unit\Lib\Spinner\Factory;

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkFactory;
use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Lib\Spinner\Contract\Builder\IBenchmarkingDriverBuilder;
use AlecRabbit\Lib\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Lib\Spinner\Factory\BenchmarkingDriverProviderFactory;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
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
        ?IBenchmarkingDriverFactory $driverFactory = null,
        ?IDriverSetup $driverSetup = null,
    ): IDriverProviderFactory {
        return
            new BenchmarkingDriverProviderFactory(
                driverFactory: $driverFactory ?? $this->getBenchmarkingDriverFactoryMock(),
                driverSetup: $driverSetup ?? $this->getDriverSetupMock(),
            );
    }

    private function getBenchmarkingDriverFactoryMock(): MockObject&IBenchmarkingDriverFactory
    {
        return $this->createMock(IBenchmarkingDriverFactory::class);
    }

    private function getDriverSetupMock(): MockObject&IDriverSetup
    {
        return $this->createMock(IDriverSetup::class);
    }

    #[Test]
    public function canCreate(): void

    {
        $driver = $this->getBenchmarkingDriverMock();

        $driverSetup = $this->getDriverSetupMock();
        $driverSetup
            ->expects(self::once())
            ->method('setup')
            ->with(self::identicalTo($driver))
        ;

        $driverFactory = $this->getBenchmarkingDriverFactoryMock();
        $driverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driver)
        ;

        $factory =
            $this->getTesteeInstance(
                driverFactory: $driverFactory,
                driverSetup: $driverSetup,
            );

        $driverProvider = $factory->create();

        self::assertSame($driver, $driverProvider->getDriver());
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

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
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
