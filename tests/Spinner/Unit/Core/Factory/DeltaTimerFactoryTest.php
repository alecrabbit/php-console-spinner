<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\DeltaTimerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class DeltaTimerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DeltaTimerFactory::class, $timerFactory);
    }

    public function getTesteeInstance(
        ?IDeltaTimerBuilder $timerBuilder = null,
        ?INowTimer $now = null,
        ?float $startTime = null,
    ): IDeltaTimerFactory {
        return
            new DeltaTimerFactory(
                timerBuilder: $timerBuilder ?? $this->getTimerBuilderMock(),
                nowTimer: $now ?? $this->getNowMock(),
                startTime: $startTime ?? 0.0,
            );
    }

    protected function getTimerBuilderMock(): MockObject&IDeltaTimerBuilder
    {
        return $this->createMock(IDeltaTimerBuilder::class);
    }

    private function getNowMock(): MockObject&INowTimer
    {
        return $this->createMock(INowTimer::class);
    }

    #[Test]
    public function canCreateTimer(): void
    {
        $startTime = 1.0;
        $timerStub = $this->getTimerStub();

        $now = $this->getNowMock();

        $timerBuilder = $this->getTimerBuilderMock();
        $timerBuilder
            ->expects(self::once())
            ->method('withNowTimer')
            ->with(self::identicalTo($now))
            ->willReturnSelf()
        ;
        $timerBuilder
            ->expects(self::once())
            ->method('withStartTime')
            ->with(self::equalTo($startTime))
            ->willReturnSelf()
        ;
        $timerBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($timerStub)
        ;

        $timerFactory = $this->getTesteeInstance(
            timerBuilder: $timerBuilder,
            now: $now,
            startTime: $startTime,
        );

        self::assertInstanceOf(DeltaTimerFactory::class, $timerFactory);
        self::assertSame($timerStub, $timerFactory->create());
    }

    protected function getTimerStub(): Stub&IDeltaTimer
    {
        return $this->createStub(IDeltaTimer::class);
    }
}
