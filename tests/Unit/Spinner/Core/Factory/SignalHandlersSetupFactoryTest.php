<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlersSetupFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersSetupFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetupFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersSetupFactory::class, $loopSetupFactory);
    }

    public function getTesteeInstance(
        ?ILegacySettingsProvider $settingsProvider = null,
        ?ILoopFactory $loopFactory = null,
        ?ISignalHandlersSetupBuilder $signalHandlersSetupBuilder = null,
    ): ISignalHandlersSetupFactory {
        return
            new SignalHandlersSetupFactory(
                settingsProvider: $settingsProvider ?? $this->getLegacySettingsProviderMock(),
                loopFactory: $loopFactory ?? $this->getLoopSingletonFactoryMock(),
                signalHandlersSetupBuilder: $signalHandlersSetupBuilder ?? $this->getSignalHandlersSetupBuilderMock(),
            );
    }

    #[Test]
    public function canCreateSignalHandlersSetup(): void
    {
        $loopSettings = $this->getLegacyLoopSettingsMock();
        $driverSettings = $this->getLegacyDriverSettingsMock();
        $loop = $this->getLoopMock();
        $signalHandlersSetupStub = $this->getSignalHandlersSetupStub();
        $loopFactory = $this->getLoopSingletonFactoryMock();
        $loopFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($loop)
        ;
        $signalHandlersSetupBuilder = $this->getSignalHandlersSetupBuilderMock();
        $signalHandlersSetupBuilder
            ->expects(self::once())
            ->method('withLoop')
            ->with($loop)
            ->willReturn($signalHandlersSetupBuilder)
        ;
        $signalHandlersSetupBuilder
            ->expects(self::once())
            ->method('withLoopSettings')
            ->with($loopSettings)
            ->willReturn($signalHandlersSetupBuilder)
        ;
        $signalHandlersSetupBuilder
            ->expects(self::once())
            ->method('withDriverSettings')
            ->with($driverSettings)
            ->willReturn($signalHandlersSetupBuilder)
        ;
        $signalHandlersSetupBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($signalHandlersSetupStub)
        ;

        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyLoopSettings')
            ->willReturn($loopSettings)
        ;
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyDriverSettings')
            ->willReturn($driverSettings)
        ;

        $loopSetupFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            loopFactory: $loopFactory,
            signalHandlersSetupBuilder: $signalHandlersSetupBuilder,
        );
        $signalHandlersSetup = $loopSetupFactory->create();
        self::assertSame($signalHandlersSetupStub, $signalHandlersSetup);
    }
}
