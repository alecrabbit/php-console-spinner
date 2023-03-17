<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\ITimer;
use Closure;

/**
 * @codeCoverageIgnore
 */
abstract class ATimer implements ITimer
{
    protected const COEFFICIENT = 1e-6; // for milliseconds
    protected Closure $timeFunction;

    public function __construct(
        ?Closure $timeFunction = null,
        protected float $time = 0.0,
    ) {
        self::assertTimeFunction($timeFunction);
        $this->timeFunction =
            $timeFunction
            ??
            static fn(): float => hrtime(true) * self::COEFFICIENT; // returns milliseconds
    }

    private static function assertTimeFunction(?Closure $timeFunction): void
    {
        if (null === $timeFunction) {
            return;
        }
        try {
            $reflection = new \ReflectionFunction($timeFunction);
            if (1 !== $reflection->getNumberOfParameters()) {
                throw new \InvalidArgumentException('Time function must have no parameters');
            }
            /** @psalm-suppress UndefinedMethod */
            if ('float' !== $reflection->getReturnType()?->getName()) {
                throw new \InvalidArgumentException('Time function must return float');
            }
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException('Time function has invalid signature: ' . $e->getMessage());
        }
    }

    public function elapsed(): float
    {
        $last = $this->time;
        $this->time = (float)($this->timeFunction)();
        return $this->time - $last;
    }
}
