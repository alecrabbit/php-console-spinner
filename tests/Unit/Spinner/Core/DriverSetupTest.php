<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\DriverSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @deprecated
 */
final class DriverSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
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

    protected function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    #[Test]
    public function doesSetup(): void
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

        $driverSetup = $this->getTesteeInstance($driverLinker);

        $driverSetup->setup($driver);
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }
}
