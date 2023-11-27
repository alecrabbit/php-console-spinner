<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\DriverFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

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
        ?IDeltaTimerFactory $timerFactory = null,
        ?IIntervalComparator $intervalComparator = null,
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
                renderer: $renderer ?? $this->getRendererMock(),
            );
    }

    private function getDriverMessagesMock(): MockObject&IDriverMessages
    {
        return $this->createMock(IDriverMessages::class);
    }

    private function getDriverBuilderMock(): MockObject&IDriverBuilder
    {
        return $this->createMock(IDriverBuilder::class);
    }

    private function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    private function getTimerFactoryMock(): MockObject&IDeltaTimerFactory
    {
        return $this->createMock(IDeltaTimerFactory::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    private function getRendererMock(): MockObject&IRenderer
    {
        return $this->createMock(IRenderer::class);
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
                driverMessages: $driverMessages,
            );

        self::assertSame($driver, $driverFactory->create());
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }
}
