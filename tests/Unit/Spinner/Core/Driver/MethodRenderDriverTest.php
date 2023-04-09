<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Tests\Unit\Spinner\Core\Driver\TestCaseForDriver;
use PHPUnit\Framework\Attributes\Test;

final class MethodRenderDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canRender(): void
    {
        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('update')
            ->with(self::equalTo(null))
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('bufferedWrite')
        ;
        $output
            ->expects(self::once())
            ->method('flush')
        ;

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('erase')
        ;
        $cursor
            ->expects(self::once())
            ->method('moveLeft')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor
            );
        $driver->initialize();

        $driver->add($spinner);

        $driver->render();
    }

    #[Test]
    public function canRenderUsingTimer(): void
    {
        $delta = 0.1;
        $timer = $this->getTimerMock();
        $timer
            ->expects(self::once())
            ->method('getDelta')
            ->willReturn($delta)
        ;

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('update')
            ->with(self::equalTo($delta))
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('bufferedWrite')
        ;

        $output
            ->expects(self::once())
            ->method('flush')
        ;

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('erase')
        ;
        $cursor
            ->expects(self::once())
            ->method('moveLeft')
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
                timer: $timer
            );
        $driver->initialize();

        $driver->add($spinner);

        $driver->render();
    }
}
