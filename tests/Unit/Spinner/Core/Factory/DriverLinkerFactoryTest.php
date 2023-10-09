<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Factory\DriverLinkerFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverLinkerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $linkerSingletonFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverLinkerFactory::class, $linkerSingletonFactory);
    }

    public function getTesteeInstance(
        ?ILoopProvider $loopProvider = null,
        ?IDriverConfig $driverConfig = null,
    ): IDriverLinkerFactory {
        return
            new DriverLinkerFactory(
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
                driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
            );
    }

    private function getDriverConfigMock(?LinkerMode $linkerMode = null): MockObject&IDriverConfig
    {
        return $this->createConfiguredMock(
            IDriverConfig::class,
            [
                'getLinkerMode' => $linkerMode ?? LinkerMode::DISABLED,
//                'getInitializationMode' => new \LogicException('Should not be called during this test.'),
            ]
        );
    }
    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

    #[Test]
    public function canGetLinker(): void
    {
        $driverConfig = $this->getDriverConfigMock();

//        $driverSettings = $this->getLegacyDriverSettingsMock();
//        $driverSettings
//            ->expects(self::once())
//            ->method('getOptionLinker')
//            ->willReturn(LinkerOption::ENABLED)
//        ;
//        $settingsProvider = $this->getLegacySettingsProviderMock();
//        $settingsProvider
//            ->expects(self::once())
//            ->method('getLegacyDriverSettings')
//            ->willReturn($driverSettings)
//        ;
        $factory =
            $this->getTesteeInstance(
                driverConfig: $driverConfig
            );

        self::assertInstanceOf(DriverLinkerFactory::class, $factory);
        self::assertInstanceOf(DriverLinker::class, $factory->create());
    }
}
