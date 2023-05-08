<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodFinalizeDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canFinalizeInitialized(): void
    {
        $finalMessage = 'finalMessage';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithNoMessage(): void
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
        $driver->finalize();
    }

    #[Test]
    public function canFinalizeUninitialized(): void
    {
        $finalMessage = 'finalMessage';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeUninitializedWithNoMessage(): void
    {
        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
        ;
        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->finalize();
    }

    #[Test]
    public function erasesAllAddedSpinners(): void
    {
        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::exactly(2))
            ->method('erase')
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
            );

        $driver->initialize();

        $spinnerOne = $this->getSpinnerMock();

        $spinnerTwo = $this->getSpinnerMock();

        $driver->add($spinnerOne);
        $driver->add($spinnerTwo);
        $driver->finalize();
    }
}
