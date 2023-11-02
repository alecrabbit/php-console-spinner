<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
                output: $driverOutput
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithEmptyFinalMessage(): void
    {
        $finalMessage = '';

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $driverOutput
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }
    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }
    #[Test]
    public function canFinalizeInitializedWithNoMessage(): void
    {
        $message = '';
        $driverMessages = $this->getDriverMessagesMock();
        $driverMessages
            ->expects(self::once())
            ->method('getFinalMessage')
            ->willReturn($message)
        ;

        $driverConfig = $this->getDriverConfigMock();
        $driverConfig
            ->expects(self::once())
            ->method('getDriverMessages')
            ->willReturn($driverMessages)
        ;

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $driverOutput,
                driverConfig: $driverConfig,
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
                output: $driverOutput
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
                output: $driverOutput
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
                output: $driverOutput
            );

        $driver->initialize();

        $spinnerOne = $this->getSpinnerMock();

        $spinnerTwo = $this->getSpinnerMock();

        $driver->add($spinnerOne);
        $driver->add($spinnerTwo);
        $driver->finalize();
    }
}
