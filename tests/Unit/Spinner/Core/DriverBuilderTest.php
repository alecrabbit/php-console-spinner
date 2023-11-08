<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\DriverBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
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
            ->withSequenceStateWriter($this->getSequenceStateWriterMock())
            ->withDeltaTimer($this->getTimerMock())
            ->withInitialInterval($interval)
            ->withDriverConfig($this->getDriverConfigMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
        self::assertSame($interval, $driver->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getSequenceStateWriterMock(): MockObject&ISequenceStateWriter
    {
        return $this->createMock(ISequenceStateWriter::class);
    }

    protected function getTimerMock(): MockObject&IDeltaTimer
    {
        return $this->createMock(IDeltaTimer::class);
    }

    private function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    #[Test]
    public function canBuildWithObserver(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        $driver = $driverBuilder
            ->withSequenceStateWriter($this->getSequenceStateWriterMock())
            ->withDeltaTimer($this->getTimerMock())
            ->withObserver($this->getObserverMock())
            ->withInitialInterval($this->getIntervalMock())
            ->withDriverConfig($this->getDriverConfigMock())
            ->build()
        ;

        self::assertInstanceOf(Driver::class, $driver);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function throwsIfSequenceStateWriterIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'SequenceStateWriter is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withDeltaTimer($this->getTimerMock())
                ->withInitialInterval($this->getIntervalMock())
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
    public function throwsIfTimerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Timer is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withSequenceStateWriter($this->getSequenceStateWriterMock())
                ->withInitialInterval($this->getIntervalMock())
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
    public function throwsIfInitialIntervalIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'InitialInterval is not set.';

        $test = function (): void {
            $driverBuilder = $this->getTesteeInstance();

            $driverBuilder
                ->withSequenceStateWriter($this->getSequenceStateWriterMock())
                ->withDeltaTimer($this->getTimerMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }
}
