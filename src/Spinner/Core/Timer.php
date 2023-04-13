<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use ReflectionFunction;
use Throwable;

final class Timer implements ITimer
{
    public function __construct(
        protected Closure $timeFunction,
        protected float $time = 0.0,
    ) {
        self::assertTimeFunction($timeFunction);
    }

    protected static function assertTimeFunction(Closure $timeFunction): void
    {
        try {
            $timeFunction();
        } catch (Throwable $e) {
            throw new InvalidArgumentException(
                'Invoke of time function throws: ' . $e->getMessage(),
                previous: $e,
            );
        }
        $reflection = new ReflectionFunction($timeFunction);

        $returnType = $reflection->getReturnType();
        if (null === $returnType) {
            throw new InvalidArgumentException(
                'Return type of time function is not specified.'
            );
        }
        $type = $returnType?->getName();
        if ('float' !== $type) {
            throw new InvalidArgumentException(
                sprintf(
                    'Time function must return "float"(e.g. "%s"), instead return type is "%s".',
                    'fn(): float => 0.0',
                    $type,
                )
            );
        }
    }

    public function getDelta(): float
    {
        $last = $this->time;
        $this->time = (float)($this->timeFunction)();
        return $this->time - $last;
    }
}
