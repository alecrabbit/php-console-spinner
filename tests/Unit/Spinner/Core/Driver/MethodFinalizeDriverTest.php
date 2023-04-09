<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Driver;

use AlecRabbit\Tests\Unit\Spinner\Core\Driver\TestCaseForDriver;
use PHPUnit\Framework\Attributes\Test;

final class MethodFinalizeDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canFinalizeInitialized(): void
    {
        $finalMessage = 'finalMessage';

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithNoMessage(): void
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
        $driver->finalize();
    }

    #[Test]
    public function canFinalizeUninitialized(): void
    {
        $finalMessage = 'finalMessage';

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

        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeUninitializedWithNoMessage(): void
    {
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

        $driver->finalize();
    }

    #[Test]
    public function erasesAllAddedSpinners(): void
    {
        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $cursor
            ->expects(self::exactly(2))
            ->method('erase')
            ->willReturnSelf()
        ;

        $cursor
            ->expects(self::exactly(2))
            ->method('flush')
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

        $spinnerOne = $this->getSpinnerMock();

        $spinnerTwo = $this->getSpinnerMock();

        $driver->add($spinnerOne);
        $driver->add($spinnerTwo);
        $driver->finalize();
    }
}
