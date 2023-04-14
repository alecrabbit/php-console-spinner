<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
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
    ): ITimer {
        return
            new Timer(
                $timeFunction ?? static fn(): float => 0.0,
                $startTime ?? 0.0,
            );
    }

    #[Test]
    public function canGetDelta(): void
    {
        $timer = $this->getTesteeInstance();

        self::assertInstanceOf(Timer::class, $timer);
        self::assertSame(0.0, $timer->getDelta());
        self::assertSame(0.0, $timer->getDelta());
    }

    #[Test]
    public function canCalculateDelta(): void
    {
        $current = 0.0;
        $step = 1.0;

        $timer = $this->getTesteeInstance(
            timeFunction: static function () use (&$current, $step): float {
                $value = $current;
                $current += $step;
                return $value;
            },
            startTime: 0.0,
        );

        self::assertInstanceOf(Timer::class, $timer);
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($step, $timer->getDelta());
        self::assertSame($current, 5.0);
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsNotSpecified(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Return type of time function is not specified.';

        $test = function () {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn() => null,
            );

            self::assertInstanceOf(Timer::class, $timer);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsInvalid(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage =
            'Time function must return "float"(e.g. "fn(): float => 0.0"), instead return type is "string".';

        $test = function () {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): string => '-',
            );

            self::assertInstanceOf(Timer::class, $timer);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsValidButActualReturnIsNot(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Invoke of time function throws:';

        $test = function () {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): float => null,
            );

            self::assertInstanceOf(Timer::class, $timer);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }
}
