<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use Closure;

class TestCaseForDriver extends TestCaseWithPrebuiltMocksAndStubs
{
    public function getTesteeInstance(
        ?ITimer $timer = null,
        ?IDriverOutput $driverOutput = null,
        ?Closure $intervalCb = null,
    ): IDriver {
        return new Driver(
            driverOutput: $driverOutput ?? $this->getDriverOutputMock(),
            timer: $timer ?? $this->getTimerMock(),
            intervalCb: $intervalCb ?? static fn() => new Interval(),
        );
    }
}
