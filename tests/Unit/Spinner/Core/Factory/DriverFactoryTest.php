<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverFactory::class, $driverFactory);
    }

    public function getTesteeInstance(
        ?IDriverBuilder $driverBuilder = null,
        ?IDriverOutputFactory $driverOutputFactory = null,
        ?ITimerFactory $timerFactory = null,
        ?IDriverSetup $driverSetup = null,
        ?IDriverSettings $driverSettings = null,
        ?ILoopSetupFactory $loopSetupFactory = null,
    ): IDriverFactory {
        return new DriverFactory(
            driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
            driverOutputFactory: $driverOutputFactory ?? $this->getDriverOutputFactoryMock(),
            timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
            driverSetup: $driverSetup ?? $this->getDriverSetupMock(),
            driverSettings: $driverSettings ?? $this->getDriverSettingsMock(),
            loopSetupFactory: $loopSetupFactory ?? $this->getLoopSetupFactoryMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $driverStub = $this->getDriverStub();

        $driverBuilder = $this->getDriverBuilderMock();
        $driverBuilder
            ->expects(self::once())
            ->method('withDriverOutput')
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withTimer')
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverStub)
        ;

        $timerFactory = $this->getTimerFactoryMock();
        $timerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getTimerStub())
        ;

        $driverOutputFactory = $this->getDriverOutputFactoryMock();
        $driverOutputFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getDriverOutputStub())
        ;

        $driverSetup = $this->getDriverSetupMock();
        $driverSetup
            ->expects(self::once())
            ->method('enableInitialization')
            ->with(true)
            ->willReturnSelf()
        ;
        $driverSetup
            ->expects(self::once())
            ->method('enableLinker')
            ->with(true)
            ->willReturnSelf()
        ;
        $driverSetup
            ->expects(self::once())
            ->method('setup')
        ;

        $driverSettings = $this->getDriverSettingsMock();
        $driverSettings
            ->expects(self::once())
            ->method('isInitializationEnabled')
            ->willReturn(true)
        ;
        $driverSettings
            ->expects(self::once())
            ->method('isLinkerEnabled')
            ->willReturn(true)
        ;

        $driverFactory =
            $this->getTesteeInstance(
                driverBuilder: $driverBuilder,
                driverOutputFactory: $driverOutputFactory,
                timerFactory: $timerFactory,
                driverSetup: $driverSetup,
                driverSettings: $driverSettings,
            );

        self::assertSame($driverStub, $driverFactory->getDriver());
    }
}