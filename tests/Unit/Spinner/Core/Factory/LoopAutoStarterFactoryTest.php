<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Legacy\ILegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Legacy\ILegacyLoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Legacy\LegacyLoopAutoStarterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopAutoStarterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopAutoStarterFactory::class, $loopAutoStarterFactory);
    }

    public function getTesteeInstance(
        ?ILegacySettingsProvider $settingsProvider = null,
        ?ILegacyLoopAutoStarterBuilder $autoStarterBuilder = null,
    ): ILegacyLoopAutoStarterFactory {
        return
            new LegacyLoopAutoStarterFactory(
                settingsProvider: $settingsProvider ?? $this->getLegacySettingsProviderMock(),
                autoStarterBuilder: $autoStarterBuilder ?? $this->getLoopAutoStarterBuilderMock(),
            );
    }

    #[Test]
    public function canCreateLoopAutoStarter(): void
    {
        $loopSettings = $this->getLegacyLoopSettingsMock();
        $autoStarterStub = $this->getLoopAutoStarterStub();
        $autoStarterBuilder = $this->getLoopAutoStarterBuilderMock();
        $autoStarterBuilder
            ->expects(self::once())
            ->method('withSettings')
            ->with($loopSettings)
            ->willReturn($autoStarterBuilder)
        ;
        $autoStarterBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($autoStarterStub)
        ;

        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyLoopSettings')
            ->willReturn($loopSettings)
        ;

        $loopAutoStarterFactory = $this->getTesteeInstance(
            settingsProvider: $settingsProvider,
            autoStarterBuilder: $autoStarterBuilder,
        );
        $loopSetup = $loopAutoStarterFactory->create();
        self::assertSame($autoStarterStub, $loopSetup);
    }
}
