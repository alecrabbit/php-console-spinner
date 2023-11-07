<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

class TestCaseForDriver extends TestCase
{
    public function getTesteeInstance(
        ?IDeltaTimer $deltaTimer = null,
        ?IDriverOutput $output = null,
        ?IInterval $initialInterval = null,
        ?IDriverConfig $driverConfig = null,
        ?IObserver $observer = null,
    ): IDriver {
        return new Driver(
            output: $output ?? $this->getDriverOutputMock(),
            deltaTimer: $deltaTimer ?? $this->getDeltaTimerMock(),
            initialInterval: $initialInterval ?? $this->getIntervalMock(),
            driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
            observer: $observer,
        );
    }

    protected function getDriverOutputMock(): MockObject&IDriverOutput
    {
        return $this->createMock(IDriverOutput::class);
    }

    protected function getDeltaTimerMock(): MockObject&IDeltaTimer
    {
        return $this->createMock(IDeltaTimer::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    protected function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    protected function getSpinnerStub(): Stub&ISpinner
    {
        return $this->createStub(ISpinner::class);
    }
}
