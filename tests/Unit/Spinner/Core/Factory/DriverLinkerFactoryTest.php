<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionLinker;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerSingletonFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverLinkerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $linkerSingletonFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerSingletonFactory::class, $linkerSingletonFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?ISettingsProvider $defaultsProvider = null,
    ): IDriverLinkerSingletonFactory {
        return new DriverLinkerSingletonFactory(
            loop: $loop ?? $this->getLoopMock(),
            defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
        );
    }

    #[Test]
    public function canGetLinker(): void
    {
        $driverSettings = $this->getDriverSettingsMock();
        $driverSettings
            ->expects(self::once())
            ->method('getOptionLinker')
            ->willReturn(OptionLinker::ENABLED)
        ;
        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->expects(self::once())
            ->method('getDriverSettings')
            ->willReturn($driverSettings)
        ;
        $linkerSingletonFactory = $this->getTesteeInstance(defaultsProvider: $defaultsProvider);

        self::assertInstanceOf(DriverLinkerSingletonFactory::class, $linkerSingletonFactory);
        self::assertInstanceOf(DriverLinker::class, $linkerSingletonFactory->getDriverLinker());
    }
}
