<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class DriverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverFactory::class, $driverFactory);
    }

    public function getTesteeInstance(
        ?IDriverBuilder $driverBuilder = null,
        ?IIntervalFactory $intervalFactory = null,
        ?IDriverOutputFactory $driverOutputFactory = null,
        ?ITimerFactory $timerFactory = null,
    ): IDriverFactory {
        return
            new DriverFactory(
                driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                driverOutputFactory: $driverOutputFactory ?? $this->getDriverOutputFactoryMock(),
                timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $driver = $this->getDriverMock();

        $driverBuilder = $this->getDriverBuilderMock();
        $driverBuilder
            ->expects(self::once())
            ->method('withDriverOutput')
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withTimer')
            ->with(self::isInstanceOf(ITimer::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withInitialInterval')
            ->with(self::isInstanceOf(IInterval::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driver)
        ;

        $timerFactory = $this->getTimerFactoryMock();
        $timerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getTimerMock())
        ;

        $driverOutputFactory = $this->getDriverOutputFactoryMock();
        $driverOutputFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getDriverOutputMock())
        ;

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createStill')
            ->willReturn($this->getIntervalMock())
        ;

        $driverFactory =
            $this->getTesteeInstance(
                driverBuilder: $driverBuilder,
                intervalFactory: $intervalFactory,
                driverOutputFactory: $driverOutputFactory,
                timerFactory: $timerFactory,
            );

        self::assertSame($driver, $driverFactory->create());
    }

    protected function getSignalHandlersSetupFactoryMock(): MockObject&ISignalHandlersSetupFactory
    {
        return $this->createMock(ISignalHandlersSetupFactory::class);
    }

    protected function getDriverStub(): Stub&IDriver
    {
        return $this->createStub(IDriver::class);
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }
}
