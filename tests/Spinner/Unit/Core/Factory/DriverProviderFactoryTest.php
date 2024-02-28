<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Driver\Factory\DriverProviderFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IDriverFactory $driverFactory = null,
        ?IDriverSetup $driverSetup = null,
    ): IDriverProviderFactory {
        return
            new DriverProviderFactory(
                driverFactory: $driverFactory ?? $this->getDriverFactoryMock(),
                driverSetup: $driverSetup ?? $this->getDriverSetupMock(),
            );
    }

    private function getDriverFactoryMock(): MockObject&IDriverFactory
    {
        return $this->createMock(IDriverFactory::class);
    }

    private function getDriverSetupMock(): MockObject&IDriverSetup
    {
        return $this->createMock(IDriverSetup::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $driver = $this->getDriverMock();

        $driverFactory = $this->getDriverFactoryMock();
        $driverFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($driver)
        ;

        $driverSetup = $this->getDriverSetupMock();
        $driverSetup
            ->expects(self::once())
            ->method('setup')
            ->with(self::identicalTo($driver))
        ;

        $factory =
            $this->getTesteeInstance(
                driverFactory: $driverFactory,
                driverSetup: $driverSetup,
            );

        $driverProvider = $factory->create();

        self::assertSame($driver, $driverProvider->getDriver());
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }
}
