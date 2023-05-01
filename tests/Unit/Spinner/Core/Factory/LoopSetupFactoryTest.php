<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\LoopSetupFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopSetupFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetupFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupFactory::class, $loopSetupFactory);
    }

    public function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
        ?ILoopSingletonFactory $loopFactory = null,
        ?ILoopSetupBuilder $loopSetupBuilder = null,
    ): ILoopSetupFactory {
        return new LoopSetupFactory(
            settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
            loopFactory: $loopFactory ?? $this->getLoopSingletonFactoryMock(),
            loopSetupBuilder: $loopSetupBuilder ?? $this->getLoopSetupBuilderMock(),
        );
    }

    #[Test]
    public function canCreateLoopSetup(): void
    {
        $loopSettings = $this->getLoopSettingsMock();
        $loop = $this->getLoopMock();
        $loopSetupStub = $this->getLoopSetupStub();
        $loopFactory = $this->getLoopSingletonFactoryMock();
        $loopFactory
            ->expects(self::once())
            ->method('getLoop')
            ->willReturn($loop)
        ;
        $loopSetupBuilder = $this->getLoopSetupBuilderMock();
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
