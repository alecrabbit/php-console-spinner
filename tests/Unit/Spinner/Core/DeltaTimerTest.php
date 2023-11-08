<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\INow;
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
        ?INow $now = null,
        ?float $startTime = null,
    ): IDeltaTimer {
        return new DeltaTimer(
            now: $now ?? $this->getNowMock(),
            startTime: $startTime ?? 0.0,
        );
    }

    private function getNowMock(): MockObject&INow
    {
        return $this->createMock(INow::class);
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

        $now = new class(0.0, $step) implements INow {
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
            now: $now,
            startTime: 0.0,
        );

        self::assertInstanceOf(DeltaTimer::class, $timer);
        self::assertSame(0.0, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($now->getCurrent(), 5.0);
    }

//    #[Test]
//    public function throwsIfTimeFunctionReturnTypeIsNotSpecified(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage = 'Return type of time function is not specified.';
//
//        $test = function (): void {
//            $timer = $this->getTesteeInstance(
//                timeFunction: static fn() => null,
//            );
//
//            self::assertInstanceOf(DeltaTimer::class, $timer);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }

//    #[Test]
//    public function throwsIfTimeFunctionReturnTypeIsInvalid(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage =
//            'Time function must return "float"(e.g. "fn(): float => 0.0"), instead return type is "string".';
//
//        $test = function (): void {
//            $timer = $this->getTesteeInstance(
//                timeFunction: static fn(): string => '-',
//            );
//
//            self::assertInstanceOf(DeltaTimer::class, $timer);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }

//    #[Test]
//    public function throwsIfTimeFunctionReturnTypeIsValidButActualReturnIsNot(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage = 'Invoke of time function throws:';
//
//        $test = function (): void {
//            $timer = $this->getTesteeInstance(
//                timeFunction: static fn(): float => null,
//            );
//
//            self::assertInstanceOf(DeltaTimer::class, $timer);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }
}
