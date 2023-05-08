<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverSetupTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverSetup = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSetup::class, $driverSetup);
    }

    public function getTesteeInstance(
        ?IDriverLinker $driverLinker = null,
    ): IDriverSetup {
        return new DriverSetup(
            linker: $driverLinker ?? $this->getDriverLinkerMock(),
        );
    }

    #[Test]
    public function doesNothingWithDefaults(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::never())
            ->method('link')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverLinker)
            ->setup($driver)
        ;
    }

    #[Test]
    public function callsInitializeOnDriverIfInitializationEnabled(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::never())
            ->method('link')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverLinker)
            ->enableInitialization(true)
            ->setup($driver)
        ;
    }

    #[Test]
    public function callsLinkOnLinkerIfLinkerEnabled(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::once())
            ->method('link')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverLinker)
            ->enableLinker(true)
            ->setup($driver)
        ;
    }

    #[Test]
    public function doesFullSetup(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::once())
            ->method('link')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverLinker)
            ->enableInitialization(true)
            ->enableLinker(true)
            ->setup($driver)
        ;
    }
}
