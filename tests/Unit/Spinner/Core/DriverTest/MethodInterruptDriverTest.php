<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MethodInterruptDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canInterruptInitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canInterruptInitializedWithNoMessage(): void
    {
        $message = '';
        $driverMessages = $this->getDriverMessagesMock();
        $driverMessages
            ->expects(self::once())
            ->method('getInterruptionMessage')
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
        $driver->interrupt();
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    #[Test]
    public function canInterruptUninitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter
            );

        $driver->interrupt($interruptMessage);
    }
}
