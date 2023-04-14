<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverAttacherSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\DriverAttacherSingletonFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverAttacherFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverAttacherSingletonFactory::class, $driverAttacherFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
        ?IDefaultsProvider $defaultsProvider = null,
    ): IDriverAttacherSingletonFactory {
        return
            new DriverAttacherSingletonFactory(
                loop: $loop ?? $this->getLoopMock(),
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
            );
    }


    #[Test]
    public function canGetAttacher(): void
    {
        $driverSettings = $this->getDriverSettingsMock();
        $driverSettings
            ->expects(self::once())
            ->method('getOptionAttacher')
            ->willReturn(OptionAttacher::ENABLED)
        ;
        $defaultsProvider = $this->getDefaultsProviderMock();
        $defaultsProvider
            ->expects(self::once())
            ->method('getDriverSettings')
            ->willReturn($driverSettings)
        ;
        $driverAttacherFactory = $this->getTesteeInstance(defaultsProvider: $defaultsProvider);

        self::assertInstanceOf(DriverAttacherSingletonFactory::class, $driverAttacherFactory);
        self::assertInstanceOf(DriverAttacher::class, $driverAttacherFactory->getAttacher());
    }
}
