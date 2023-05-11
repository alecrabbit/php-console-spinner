<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\LoopAutoStarterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopAutoStarterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAutoStarterFactory::class, $loopAutoStarterFactory);
    }

    public function getTesteeInstance(
        ?ISettingsProvider $settingsProvider = null,
        ?ILoopAutoStarterBuilder $autoStarterBuilder = null,
    ): ILoopAutoStarterFactory {
        return
            new LoopAutoStarterFactory(
                settingsProvider: $settingsProvider ?? $this->getSettingsProviderMock(),
                autoStarterBuilder: $autoStarterBuilder ?? $this->getLoopAutoStarterBuilderMock(),
            );
    }

    #[Test]
    public function canCreateLoopAutoStarter(): void
    {
        $loopSettings = $this->getLoopSettingsMock();
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

        $settingsProvider = $this->getSettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLoopSettings')
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
