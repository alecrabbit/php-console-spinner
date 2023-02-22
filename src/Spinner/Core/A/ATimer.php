<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\ITimer;
use Closure;

/**
 * @codeCoverageIgnore
 */
abstract class ATimer implements ITimer
{
    protected const COEFFICIENT = 1e-6; // for milliseconds
    protected Closure $timeFunction;

    public function __construct(
        ?callable $timeFunction = null,
        protected float $time = 0.0,
    ) {
        $this->timeFunction =
            $timeFunction
            ??
            static fn() => hrtime(true) * self::COEFFICIENT; // returns milliseconds
    }

    public function elapsed(): float
    {
        $last = $this->time;
        $this->time = ($this->timeFunction)();
        return $this->time - $last;
    }
}
