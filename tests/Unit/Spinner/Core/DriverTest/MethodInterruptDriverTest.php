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

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canInterruptInitializedWithNoMessage(): void
    {
        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::never())
            ->method('write')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->interrupt();
    }

    #[Test]
    public function canInterruptUninitialized(): void
    {
        $interruptMessage = 'interruptMessage';

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::never())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::never())
            ->method('write')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->interrupt($interruptMessage);
    }
}
