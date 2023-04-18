<?php

declare(strict_types=1);

// 03.04.23

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\TimerBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class TimerBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TimerBuilder::class, $timerFactory);
    }

    public function getTesteeInstance(): ITimerBuilder
    {
        return new TimerBuilder();
    }

    #[Test]
    public function canCreateTimer(): void
    {
        $timerBuilder = $this->getTesteeInstance();

        $timer =
            $timerBuilder
                ->withTimeFunction(static fn(): float => 0.0)
                ->withStartTime(0.0)
                ->build()
        ;
        self::assertInstanceOf(Timer::class, $timer);
    }
}
