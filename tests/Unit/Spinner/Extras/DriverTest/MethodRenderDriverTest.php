<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodRenderDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canRender(): void
    {
        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('getFrame')
            ->with(self::equalTo(null))
        ;

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('write')
        ;

        $driver =
            $this->getTesteeInstance(
                driverOutput: $driverOutput
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
            ->method('getFrame')
            ->with(self::equalTo($delta))
        ;

        $driverOutput = $this->getDriverOutputMock();
        $driverOutput
            ->expects(self::once())
            ->method('write')
        ;

        $driver =
            $this->getTesteeInstance(
                timer: $timer,
                driverOutput: $driverOutput
            );
        $driver->initialize();

        $driver->add($spinner);

        $driver->render();
    }
}
