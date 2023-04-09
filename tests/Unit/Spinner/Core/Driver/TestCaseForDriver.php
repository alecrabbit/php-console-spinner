<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use Closure;

class TestCaseForDriver extends TestCaseWithPrebuiltMocksAndStubs
{
    public function getTesteeInstance(
        ?IBufferedOutput $output = null,
        ?ICursor $cursor = null,
        ?ITimer $timer = null,
        ?Closure $intervalCb = null,
    ): IDriver {
        return
            new Driver(
                output: $output ?? $this->getBufferedOutputMock(),
                cursor: $cursor ?? $this->getCursorMock(),
                timer: $timer ?? $this->getTimerMock(),
                intervalCb: $intervalCb ?? static fn() => new Interval(),
            );
    }
}
