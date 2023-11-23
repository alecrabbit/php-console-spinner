<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\INowTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\IDeltaTimerBuilder;
use AlecRabbit\Spinner\Core\Builder\DeltaTimerBuilder;
use AlecRabbit\Spinner\Core\DeltaTimer;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DeltaTimerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DeltaTimerBuilder::class, $timerFactory);
    }

    public function getTesteeInstance(): IDeltaTimerBuilder
    {
        return new DeltaTimerBuilder();
    }

    #[Test]
    public function canCreateTimer(): void
    {
        $timerBuilder = $this->getTesteeInstance();

        $now =
            new class() implements INowTimer {
                public function now(): float
                {
                    return 0.0;
                }
            };

        $timer =
            $timerBuilder
                ->withNowTimer($now)
                ->withStartTime(0.0)
                ->build()
        ;
        self::assertInstanceOf(DeltaTimer::class, $timer);
    }

    #[Test]
    public function throwsIfNowIsNotSet(): void
    {
        $timerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('NowTimer is not set.');

        $timerBuilder
            ->withStartTime(0.0)
            ->build()
        ;
    }

    #[Test]
    public function throwsIfStartTimeIsNotSet(): void
    {
        $timerBuilder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Start time is not set.');

        $timerBuilder
            ->withNowTimer($this->getNowMock())
            ->build()
        ;
    }

    private function getNowMock(): MockObject&INowTimer
    {
        return $this->createMock(INowTimer::class);
    }
}
