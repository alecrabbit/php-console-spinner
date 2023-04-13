<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use Closure;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;

final class Timer implements ITimer
{
    public function __construct(
        protected Closure $timeFunction,
        protected float $time = 0.0,
    ) {
        self::assertTimeFunction($timeFunction);
    }

    private static function assertTimeFunction(Closure $timeFunction): void
    {
        try {
            $reflection = new ReflectionFunction($timeFunction);
            /** @psalm-suppress UndefinedMethod */
            if ('float' !== $reflection->getReturnType()?->getName()) {
                throw new InvalidArgumentException('Time function must return float, e.g. "fn(): float => 0.0".');
            }
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException('Time function has invalid signature: ' . $e->getMessage());
        }
    }

    public function getDelta(): float
    {
        $last = $this->time;
        $this->time = (float)($this->timeFunction)();
        return $this->time - $last;
    }
}
