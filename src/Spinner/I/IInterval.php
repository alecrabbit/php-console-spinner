<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\I;

interface IInterval
{
    final public const MIN_INTERVAL_MILLISECONDS = 10;      // 10 milliseconds
    final public const MAX_INTERVAL_MILLISECONDS = 900000;  // 15 minutes

    public function toMicroseconds(): float;

    public function toMilliseconds(): float;

    public function toSeconds(): float;

    public function smallest(mixed $other): IInterval;
}
