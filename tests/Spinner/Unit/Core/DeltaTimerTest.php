<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\DeltaTimer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DeltaTimerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $timer = $this->getTesteeInstance();

        self::assertInstanceOf(DeltaTimer::class, $timer);
    }

    protected function getTesteeInstance(
        ?INowTimer $nowTimer = null,
        ?float $startTime = null,
    ): IDeltaTimer {
        return new DeltaTimer(
            nowTimer: $nowTimer ?? $this->getNowMock(),
            startTime: $startTime ?? 0.0,
        );
    }

    private function getNowMock(): MockObject&INowTimer
    {
        return $this->createMock(INowTimer::class);
    }

    #[Test]
    public function canGetDelta(): void
    {
        $timer = $this->getTesteeInstance();

        self::assertInstanceOf(DeltaTimer::class, $timer);
        self::assertSame(0.0, $timer->getDelta());
        self::assertSame(0.0, $timer->getDelta());
    }

    #[Test]
    public function canCalculateDelta(): void
    {
        $step = 1.0;

        $nowTimer = new class(0.0, $step) implements INowTimer {
            public function __construct(
                private float $current,
                private float $step,
            ) {
            }

            public function getCurrent(): float
            {
                return $this->current;
            }

            public function now(): float
            {
                $value = $this->current;
                $this->current += $this->step;
                return $value;
            }
        };

        $timer = $this->getTesteeInstance(
            nowTimer: $nowTimer,
            startTime: 0.0,
        );

        self::assertInstanceOf(DeltaTimer::class, $timer);
        self::assertSame(0.0, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($nowTimer->getCurrent(), 5.0);
    }
}
