<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
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
        ?IDriverAttacher $driverAttacher = null,
    ): IDriverSetup {
        return
            new DriverSetup(
                attacher: $driverAttacher ?? $this->getDriverAttacherMock(),
            );
    }

    #[Test]
    public function doesNothingWithDefaults(): void
    {
        $driverAttacher = $this->getDriverAttacherMock();
        $driverAttacher
            ->expects(self::never())
            ->method('attach')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverAttacher)
            ->setup($driver)
        ;
    }

    #[Test]
    public function callsInitializeOnDriverIfInitializationEnabled(): void
    {
        $driverAttacher = $this->getDriverAttacherMock();
        $driverAttacher
            ->expects(self::never())
            ->method('attach')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverAttacher)
            ->enableInitialization(true)
            ->setup($driver)
        ;
    }

    #[Test]
    public function callsAttachOnAttacherIfAttacherEnabled(): void
    {
        $driverAttacher = $this->getDriverAttacherMock();
        $driverAttacher
            ->expects(self::once())
            ->method('attach')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::never())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverAttacher)
            ->enableAttacher(true)
            ->setup($driver)
        ;
    }    #[Test]
    public function doesFullSetup(): void
    {
        $driverAttacher = $this->getDriverAttacherMock();
        $driverAttacher
            ->expects(self::once())
            ->method('attach')
        ;

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $this->getTesteeInstance($driverAttacher)
            ->enableInitialization(true)
            ->enableAttacher(true)
            ->setup($driver)
        ;
    }
}
