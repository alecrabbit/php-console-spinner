<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class DriverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverFactory::class, $driverFactory);
    }

    public function getTesteeInstance(
        ?IDriverBuilder $driverBuilder = null,
        ?IIntervalFactory $intervalFactory = null,
        ?ISequenceStateWriterFactory $sequenceStateWriterFactory = null,
        ?IDeltaTimerFactory $timerFactory = null,
        ?IDriverConfig $driverConfig = null,
        ?ISequenceStateBuilder $sequenceStateBuilder = null,
    ): IDriverFactory {
        return
            new DriverFactory(
                driverConfig: $driverConfig ?? $this->getDriverConfigMock(),
                driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
                sequenceStateWriterFactory: $sequenceStateWriterFactory ?? $this->getSequenceStateWriterFactoryMock(),
                sequenceStateBuilder: $sequenceStateBuilder ?? $this->getSequenceStateBuilderMock(),
            );
    }

    private function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    protected function getDriverBuilderMock(): MockObject&IDriverBuilder
    {
        return $this->createMock(IDriverBuilder::class);
    }

    protected function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    protected function getTimerFactoryMock(): MockObject&IDeltaTimerFactory
    {
        return $this->createMock(IDeltaTimerFactory::class);
    }

    protected function getSequenceStateWriterFactoryMock(): MockObject&ISequenceStateWriterFactory
    {
        return $this->createMock(ISequenceStateWriterFactory::class);
    }

    private function getSequenceStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $sequenceStateBuilder = $this->getSequenceStateBuilderMock();

        $driver = $this->getDriverMock();

        $driverBuilder = $this->getDriverBuilderMock();
        $driverBuilder
            ->expects(self::once())
            ->method('withSequenceStateWriter')
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withDeltaTimer')
            ->with(self::isInstanceOf(IDeltaTimer::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withSequenceStateBuilder')
            ->with(self::identicalTo($sequenceStateBuilder))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withInitialInterval')
            ->with(self::isInstanceOf(IInterval::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withDriverConfig')
            ->with(self::isInstanceOf(IDriverConfig::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driver)
        ;

        $timerFactory = $this->getTimerFactoryMock();
        $timerFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getTimerMock())
        ;

        $sequenceStateWriterFactory = $this->getSequenceStateWriterFactoryMock();
        $sequenceStateWriterFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getSequenceStateWriterMock())
        ;

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createStill')
            ->willReturn($this->getIntervalMock())
        ;

        $driverFactory =
            $this->getTesteeInstance(
                driverBuilder: $driverBuilder,
                intervalFactory: $intervalFactory,
                sequenceStateWriterFactory: $sequenceStateWriterFactory,
                timerFactory: $timerFactory,
                sequenceStateBuilder: $sequenceStateBuilder,
            );

        self::assertSame($driver, $driverFactory->create());
    }

    protected function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    protected function getTimerMock(): MockObject&IDeltaTimer
    {
        return $this->createMock(IDeltaTimer::class);
    }

    protected function getSequenceStateWriterMock(): MockObject&ISequenceStateWriter
    {
        return $this->createMock(ISequenceStateWriter::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    protected function getDriverStub(): Stub&IDriver
    {
        return $this->createStub(IDriver::class);
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }
}
