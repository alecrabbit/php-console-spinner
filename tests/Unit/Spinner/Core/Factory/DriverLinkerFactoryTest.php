<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverLinkerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $linkerSingletonFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerFactory::class, $linkerSingletonFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?ILegacySettingsProvider $settingsProvider = null,
    ): IDriverLinkerFactory {
        return new DriverLinkerFactory(
            loop: $loop ?? $this->getLoopMock(),
            settingsProvider: $settingsProvider ?? $this->getLegacySettingsProviderMock(),
        );
    }

    #[Test]
    public function canGetLinker(): void
    {
        $driverSettings = $this->getLegacyDriverSettingsMock();
        $driverSettings
            ->expects(self::once())
            ->method('getOptionLinker')
            ->willReturn(LinkerOption::ENABLED)
        ;
        $settingsProvider = $this->getLegacySettingsProviderMock();
        $settingsProvider
            ->expects(self::once())
            ->method('getLegacyDriverSettings')
            ->willReturn($driverSettings)
        ;
        $linkerSingletonFactory = $this->getTesteeInstance(settingsProvider: $settingsProvider);

        self::assertInstanceOf(DriverLinkerFactory::class, $linkerSingletonFactory);
        self::assertInstanceOf(DriverLinker::class, $linkerSingletonFactory->getDriverLinker());
    }
}
