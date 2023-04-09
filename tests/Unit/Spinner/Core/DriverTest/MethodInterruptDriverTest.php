<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Tests\Unit\Spinner\Core\DriverTest\TestCaseForDriver;
use PHPUnit\Framework\Attributes\Test;

final class MethodInterruptDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canInterruptInitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canInterruptInitializedWithNoMessage(): void
    {
        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo(null))
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->initialize();
        $driver->interrupt();
    }

    #[Test]
    public function canInterruptUninitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::never())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->interrupt($interruptMessage);
    }
}
