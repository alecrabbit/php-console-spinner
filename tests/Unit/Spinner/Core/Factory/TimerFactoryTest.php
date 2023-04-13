<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class TimerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TimerFactory::class, $timerFactory);
    }

    public function getTesteeInstance(
        ?ITimerBuilder $timerBuilder = null,
    ): ITimerFactory {
        return
            new TimerFactory(timerBuilder: $timerBuilder ?? $this->getTimerBuilderMock());
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

}
