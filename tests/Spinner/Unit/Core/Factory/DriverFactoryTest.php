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
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
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
        ?IIntervalComparator $intervalComparator = null,
        ?ISequenceStateBuilder $sequenceStateBuilder = null,
        ?IDriverMessages $driverMessages = null,
        ?IRenderer $renderer = null,
    ): IDriverFactory {
        return
            new DriverFactory(
                driverMessages: $driverMessages ?? $this->getDriverMessagesMock(),
                driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                timerFactory: $timerFactory ?? $this->getTimerFactoryMock(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
                sequenceStateWriterFactory: $sequenceStateWriterFactory ?? $this->getSequenceStateWriterFactoryMock(),
                sequenceStateBuilder: $sequenceStateBuilder ?? $this->getSequenceStateBuilderMock(),
                renderer: $renderer ?? $this->getRendererMock(),
            );
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
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

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
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
        $interval = $this->getIntervalMock();

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createStill')
            ->willReturn($interval)
        ;

        $driverMessages = $this->getDriverMessagesMock();
        $sequenceStateBuilder = $this->getSequenceStateBuilderMock();

        $driver = $this->getDriverMock();

        $driverBuilder = $this->getDriverBuilderMock();
        $driverBuilder
            ->expects(self::once())
            ->method('withDeltaTimer')
            ->with(self::isInstanceOf(IDeltaTimer::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withInitialInterval')
            ->with(self::identicalTo($interval))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withDriverMessages')
            ->with(self::identicalTo($driverMessages))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withIntervalComparator')
            ->with(self::isInstanceOf(IIntervalComparator::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('withRenderer')
            ->with(self::isInstanceOf(IRenderer::class))
            ->willReturnSelf()
        ;
        $driverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driver)
        ;

        $intervalComparator = $this->getIntervalComparatorMock();

        $driverFactory =
            $this->getTesteeInstance(
                driverBuilder: $driverBuilder,
                intervalFactory: $intervalFactory,
                intervalComparator: $intervalComparator,
                sequenceStateBuilder: $sequenceStateBuilder,
                driverMessages: $driverMessages,
            );

        self::assertSame($driver, $driverFactory->create());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
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

    protected function getDriverStub(): Stub&IDriver
    {
        return $this->createStub(IDriver::class);
    }

    protected function getLinkerConfigMock(): MockObject&ILinkerConfig
    {
        return $this->createMock(ILinkerConfig::class);
    }

    private function getDriverConfigMock(): MockObject&IDriverConfig
    {
        return $this->createMock(IDriverConfig::class);
    }

    private function getRendererMock(): MockObject&IRenderer
    {
        return $this->createMock(IRenderer::class);
    }
}
