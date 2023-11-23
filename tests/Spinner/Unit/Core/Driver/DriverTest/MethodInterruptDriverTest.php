<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodInterruptDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canInterruptInitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
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

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer,
                driverMessages: $driverMessages,
            );

        $driver->initialize();
        $driver->interrupt();
    }

    #[Test]
    public function canInterruptUninitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->interrupt($interruptMessage);
    }
}
