<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Stopwatch;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Stopwatch\Contract\ITimer;
use AlecRabbit\Stopwatch\Contract\TimeUnit;
use AlecRabbit\Stopwatch\MicrosecondTimer;
use AlecRabbit\Tests\TestCase\TestCase;
use Closure;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

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
        ?Closure $timeFunction = null,
    ): ITimer {
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
        $timeFunction = static fn(): int|float => $value;

        $timer = $this->getTesteeInstance(
            timeFunction: $timeFunction,
        );

        self::assertSame($value, $timer->now());
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsValidButActualReturnIsNot(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Invoke of time function throws:';

        $test = function (): void {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): float => null,
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeAllowsNull(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Time function return type allows null.';

        $test = function (): void {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): ?float => null,
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionUnionReturnTypeAllowsNull(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Time function return type allows null.';

        $test = function (): void {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): null|int|float => null,
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsIntersection(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Unexpected intersection type.';

        $test = function (): void {
            $intersectionStub = $this->getIntersectionStub();

            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): ITimer&IInterval => $intersectionStub,
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    private function getIntersectionStub(): ITimer&IInterval
    {
        return
            new class implements ITimer, IInterval {
                public function getUnit(): TimeUnit
                {
                    return TimeUnit::SECOND;
                }

                public function toMicroseconds(): float
                {
                    // TODO: Implement toMicroseconds() method.
                    throw new RuntimeException('Not implemented.');
                }

                public function toMilliseconds(): float
                {
                    // TODO: Implement toMilliseconds() method.
                    throw new RuntimeException('Not implemented.');
                }

                public function toSeconds(): float
                {
                    // TODO: Implement toSeconds() method.
                    throw new RuntimeException('Not implemented.');
                }

                public function smallest(mixed $other): IInterval
                {
                    // TODO: Implement smallest() method.
                    throw new RuntimeException('Not implemented.');
                }

                public function now(): int|float
                {
                    // TODO: Implement now() method.
                    throw new RuntimeException('Not implemented.');
                }
            };
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsNotSpecified(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Return type of time function is not specified.';

        $test = function (): void {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn() => null,
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsInvalid(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage =
            'Time function must return "int|float"(e.g. "fn(): int|float => 0.0"), instead return type is "string".';

        $test = function (): void {
            $timer = $this->getTesteeInstance(
                timeFunction: static fn(): string => '-',
            );

            self::assertInstanceOf(MicrosecondTimer::class, $timer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
