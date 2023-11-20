<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Stopwatch;

use AlecRabbit\Benchmark\Contract\ITimer;
use AlecRabbit\Benchmark\Contract\TimeUnit;
use AlecRabbit\Benchmark\Stopwatch\MicrosecondTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgument;
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
        $exceptionClass = InvalidArgument::class;
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
        $exceptionClass = InvalidArgument::class;
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
        $exceptionClass = InvalidArgument::class;
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
        $exceptionClass = InvalidArgument::class;
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
            new class() implements ITimer, IInterval {
                public function getUnit(): TimeUnit
                {
                    return TimeUnit::SECOND;
                }

                public function toMicroseconds(): float
                {
                    throw new RuntimeException('INTENTIONALLY Not implemented.');
                }

                public function toMilliseconds(): float
                {
                    throw new RuntimeException('INTENTIONALLY Not implemented.');
                }

                public function toSeconds(): float
                {
                    throw new RuntimeException('INTENTIONALLY Not implemented.');
                }

                /** @inheritDoc */
                public function smallest(mixed $other): IInterval
                {
                    throw new RuntimeException('INTENTIONALLY Not implemented.');
                }

                public function now(): int|float
                {
                    throw new RuntimeException('INTENTIONALLY Not implemented.');
                }
            };
    }

    #[Test]
    public function throwsIfTimeFunctionReturnTypeIsNotSpecified(): void
    {
        $exceptionClass = InvalidArgument::class;
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
        $exceptionClass = InvalidArgument::class;
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
