<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark;

use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\MicrosecondTimer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class MicrosecondTimerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $timer = $this->getTesteeInstance();

        self::assertInstanceOf(MicrosecondTimer::class, $timer);
    }

    private function getTesteeInstance(
        ?TimeUnit $unit = null,
        ?\Closure $timeFunction = null,
    ): ITimer
    {
        return
            new MicrosecondTimer(
                unit: $unit ?? TimeUnit::MINUTE,
                timeFunction: $timeFunction,
            );
    }

    #[Test]
    public function canGetUnit(): void
    {
        $unit = TimeUnit::MICROSECOND;

        $timer = $this->getTesteeInstance(
            unit: $unit,
        );

        self::assertSame($unit, $timer->getUnit());
    }

    #[Test]
    public function canGetNow(): void
    {
        $value = 1.0;
        $timeFunction = static fn(): float => $value;

        $timer = $this->getTesteeInstance(
            timeFunction: $timeFunction,
        );

        self::assertSame($value, $timer->now());
    }
}
