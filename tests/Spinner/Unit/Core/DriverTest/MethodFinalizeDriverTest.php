<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\DriverTest;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MethodFinalizeDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canFinalizeInitialized(): void
    {
        $finalMessage = 'finalMessage';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithEmptyFinalMessage(): void
    {
        $finalMessage = '';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
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

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter,
                driverConfig: $driverConfig,
            );

        $driver->initialize();
        $driver->finalize();
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    #[Test]
    public function canFinalizeUninitialized(): void
    {
        $finalMessage = 'finalMessage';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeUninitializedWithNoMessage(): void
    {
        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
        ;
        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->finalize();
    }

    #[Test]
    public function erasesAllAddedSpinners(): void
    {
        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::exactly(2))
            ->method('erase')
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->initialize();

        $spinnerOne = $this->getSpinnerMock();

        $spinnerTwo = $this->getSpinnerMock();

        $driver->add($spinnerOne);
        $driver->add($spinnerTwo);
        $driver->finalize();
    }
}
