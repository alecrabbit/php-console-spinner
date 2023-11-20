<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IInterval
{
    final public const MIN_INTERVAL_MILLISECONDS = 10;
    final public const MAX_INTERVAL_MILLISECONDS = 900000;  // 15 minutes

    public function toMicroseconds(): float;

    public function toMilliseconds(): float;

    public function toSeconds(): float;

    /**
     * @deprecated Use IIntervalComparator instead
     */
    public function smallest(mixed $other): IInterval;
}
