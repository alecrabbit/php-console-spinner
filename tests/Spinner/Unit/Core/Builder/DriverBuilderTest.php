<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Driver\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Driver\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverBuilder::class, $driverBuilder);
    }

    public function getTesteeInstance(): IDriverBuilder
    {
        return
            new DriverBuilder();
    }

    #[Test]
    public function canBuildDriverWithCustomInterval(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $interval = $this->getIntervalMock();

        $driver = $driverBuilder
            ->withRenderer($this->getRendererMock())
            ->withInitialInterval($interval)
            ->withIntervalComparator($this->getIntervalComparatorMock())
            ->withDriverMessages($this->getDriverMessagesMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
        self::assertSame($interval, $driver->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getRendererMock(): MockObject&IRenderer
    {
        return $this->createMock(IRenderer::class);
    }

    protected function getTimerMock(): MockObject&IDeltaTimer
    {
        return $this->createMock(IDeltaTimer::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    #[Test]
    public function canBuildWithObserver(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withRenderer($this->getRendererMock())
            ->withObserver($this->getObserverMock())
            ->withInitialInterval($this->getIntervalMock())
            ->withDriverMessages($this->getDriverMessagesMock())
            ->withIntervalComparator($this->getIntervalComparatorMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function throwsIfInitialIntervalIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'InitialInterval is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withRenderer($this->getRendererMock())
                ->withDriverMessages($this->getDriverMessagesMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwIfDriverMessagesIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'DriverMessages is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withRenderer($this->getRendererMock())
                ->withObserver($this->getObserverMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withIntervalComparator($this->getIntervalComparatorMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwIfRendererIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Renderer is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDriverMessages($this->getDriverMessagesMock())
                ->withObserver($this->getObserverMock())
                ->withInitialInterval($this->getIntervalMock())
                ->withIntervalComparator($this->getIntervalComparatorMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getSequenceStateWriterMock(): MockObject&ISequenceStateWriter
    {
        return $this->createMock(ISequenceStateWriter::class);
    }

    protected function getSequenceStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }

    private function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }
}
