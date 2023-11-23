<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

class TestCaseForDriver extends TestCase
{
    public function getTesteeInstance(
        ?IRenderer $renderer = null,
        ?IDeltaTimer $deltaTimer = null,
        ?ISequenceStateWriter $stateWriter = null,
        ?ISequenceStateBuilder $stateBuilder = null,
        ?IInterval $initialInterval = null,
        ?IDriverMessages $driverMessages = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IObserver $observer = null,
    ): IDriver {
        return new Driver(
            renderer: $renderer ?? $this->getRendererMock(),
            stateBuilder: $stateBuilder ?? $this->getSequenceStateBuilderMock(),
            deltaTimer: $deltaTimer ?? $this->getDeltaTimerMock(),
            initialInterval: $initialInterval ?? $this->getIntervalMock(),
            driverMessages: $driverMessages ?? $this->getDriverMessagesMock(),
            intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
            observer: $observer,
        );
    }

    protected function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    protected function getSequenceStateWriterMock(): MockObject&ISequenceStateWriter
    {
        return $this->createMock(ISequenceStateWriter::class);
    }

    protected function getSequenceStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
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

    protected function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
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

    protected function getRendererMock(): MockObject&IRenderer
    {
        return $this->createMock(IRenderer::class);
    }
}
