<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\SignalHandlersSetupFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersSetupFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetupFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlersSetupFactory::class, $loopSetupFactory);
    }

    public function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
        ?ILoopFactory $loopFactory = null,
        ?ISignalHandlersSetupBuilder $loopSetupBuilder = null,
    ): ISignalHandlersSetupFactory {
        return
            new SignalHandlersSetupFactory(
                settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
                loopFactory: $loopFactory ?? $this->getLoopSingletonFactoryMock(),
                loopSetupBuilder: $loopSetupBuilder ?? $this->getSignalHandlersSetupBuilderMock(),
            );
    }

    #[Test]
    public function canCreateSignalHandlersSetup(): void
    {
        $loopSettings = $this->getLoopSettingsMock();
        $loop = $this->getLoopMock();
        $loopSetupStub = $this->getSignalHandlersSetupStub();
        $loopFactory = $this->getLoopSingletonFactoryMock();
        $loopFactory
            ->expects(self::once())
            ->method('getLoop')
            ->willReturn($loop)
        ;
        $loopSetupBuilder = $this->getSignalHandlersSetupBuilderMock();
        $loopSetupBuilder
            ->expects(self::once())
            ->method('withLoop')
            ->with($loop)
            ->willReturn($loopSetupBuilder)
        ;
        $loopSetupBuilder
            ->expects(self::once())
            ->method('withSettings')
            ->with($loopSettings)
            ->willReturn($loopSetupBuilder)
        ;
        $loopSetupBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($loopSetupStub)
        ;

        $settingsProvider = $this->getSettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLoopSettings')
            ->willReturn($loopSettings)
        ;

        $loopSetupFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            loopFactory: $loopFactory,
            loopSetupBuilder: $loopSetupBuilder,
        );
        $loopSetup = $loopSetupFactory->create();
        self::assertSame($loopSetupStub, $loopSetup);
    }
}
