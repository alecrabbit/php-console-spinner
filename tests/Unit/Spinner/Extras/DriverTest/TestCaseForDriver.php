<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Extras\Driver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;

class TestCaseForDriver extends TestCaseWithPrebuiltMocksAndStubs
{
    public function getTesteeInstance(
        ?ITimer $timer = null,
        ?IDriverOutput $driverOutput = null,
        ?IInterval $initialInterval = null,
        ?IObserver $observer = null,
    ): IDriver {
        return new Driver(
            driverOutput: $driverOutput ?? $this->getDriverOutputMock(),
            timer: $timer ?? $this->getTimerMock(),
            initialInterval: $initialInterval ?? $this->getIntervalMock(),
            observer: $observer,
        );
    }
}
