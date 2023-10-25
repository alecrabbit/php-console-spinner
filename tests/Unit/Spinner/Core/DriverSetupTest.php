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

final class DriverSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverLinker = $this->getTesteeInstance();

        self::assertInstanceOf(DriverSetup::class, $driverLinker);
    }

    public function getTesteeInstance(
        ?IDriverLinker $driverLinker = null,
    ): IDriverSetup {
        return new DriverSetup(
            driverLinker: $driverLinker ?? $this->getDriverLinkerMock(),
        );
    }

    private function getDriverLinkerMock(): MockObject&IDriverLinker
    {
        return $this->createMock(IDriverLinker::class);
    }

    #[Test]
    public function canSetup(): void
    {
        $driverLinker = $this->getDriverLinkerMock();
        $driverLinker
            ->expects(self::once())
            ->method('link')
        ;

        $driverSetup =
            $this->getTesteeInstance(
                driverLinker: $driverLinker
            );

        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $driverSetup->setup($driver);
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }
}
