<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Builder\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class TimerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TimerFactory::class, $timerFactory);
    }

    public function getTesteeInstance(
        ?ITimerBuilder $timerBuilder = null,
    ): ITimerFactory {
        return new TimerFactory(timerBuilder: $timerBuilder ?? $this->getTimerBuilderMock());
    }

    protected function getTimerBuilderMock(): MockObject&ITimerBuilder
    {
        return $this->createMock(ITimerBuilder::class);
    }

    #[Test]
    public function canCreateTimer(): void
    {
        $timerStub = $this->getTimerStub();

        $timerBuilder = $this->getTimerBuilderMock();
        $timerBuilder
            ->expects(self::once())
            ->method('withTimeFunction')
//            ->with(self::equalTo(static fn(): float => 0.0))
            ->willReturnSelf()
        ;
        $timerBuilder
            ->expects(self::once())
            ->method('withStartTime')
            ->with(self::equalTo(0.0))
            ->willReturnSelf()
        ;
        $timerBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($timerStub)
        ;

        $timerFactory = $this->getTesteeInstance(timerBuilder: $timerBuilder);

        self::assertInstanceOf(TimerFactory::class, $timerFactory);
        self::assertSame($timerStub, $timerFactory->create());
    }

    protected function getTimerStub(): Stub&ITimer
    {
        return $this->createStub(ITimer::class);
    }
}
