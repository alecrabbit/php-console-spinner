<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Tests\TestCase\TestCase;
use Closure;
use PHPUnit\Framework\Attributes\Test;

final class TimerTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $timer = $this->getTesteeInstance();

        self::assertInstanceOf(Timer::class, $timer);
    }

    protected function getTesteeInstance(
        ?Closure $timeFunction = null,
        ?float $startTime = null,
    ): ITimer
    {
        return
            new Timer(
                $timeFunction ?? static fn(): float => 0.0,
                $startTime ?? 0.0,
            );
    }

}
