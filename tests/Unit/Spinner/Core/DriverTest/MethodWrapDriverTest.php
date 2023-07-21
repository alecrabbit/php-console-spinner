<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\SpinnerState;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

final class MethodWrapDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canWrap(): void
    {
        $output = $this->getDriverOutputMock();
        // Make sure method erase() is called. See ADriver::wrap()
        $output
            ->expects(self::once())
            ->method('erase')
            ->with(self::isInstanceOf(SpinnerState::class))
        ;
        // Make sure method render() is called. See ADriver::wrap()
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::isInstanceOf(SpinnerState::class))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
            );

        $counter = 0;
        $callback = static function () use (&$counter) {
            $counter++;
        };

        $wrapped = $driver->wrap($callback);

        $wrapped();
        // Make sure wrapped callback is called. See ADriver::wrap()
        self::assertEquals(1, $counter);
    }

    /**
     * Get testee instance derived from abstract class ADriver.
     */
    public function getTesteeInstance(
        ?ITimer $timer = null,
        ?IDriverOutput $output = null,
        ?IInterval $initialInterval = null,
        ?ILegacyDriverSettings $driverSettings = null,
        ?IObserver $observer = null,
    ): IDriver {
        return new class(
            output: $output ?? $this->getDriverOutputMock(),
            timer: $timer ?? $this->getTimerMock(),
            initialInterval: $initialInterval ?? $this->getIntervalMock(),
            driverSettings: $driverSettings ?? $this->getLegacyDriverSettingsMock(),
            observer: $observer,
        ) extends ADriver {
            protected function erase(): void
            {
                $this->output->erase(new SpinnerState());
            }

            public function render(?float $dt = null): void
            {
                $this->output->write(new SpinnerState());
            }

            public function add(ISpinner $spinner): void
            {
                throw new RuntimeException('Not implemented. Should not be called.');
            }

            public function remove(ISpinner $spinner): void
            {
                throw new RuntimeException('Not implemented. Should not be called.');
            }

            public function update(ISubject $subject): void
            {
                throw new RuntimeException('Not implemented. Should not be called.');
            }
        };
    }
}
