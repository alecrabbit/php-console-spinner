<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;

final readonly class IntervalComparator implements IIntervalComparator
{
    public function smallest(IInterval $first, IInterval ...$other): IInterval
    {
        $smallest = $first;

        foreach ($other as $interval) {
            if ($interval->toMicroseconds() < $smallest->toMicroseconds()) {
                $smallest = $interval;
            }
        }

        return $smallest;
    }

    public function largest(IInterval $first, IInterval ...$other): IInterval
    {
        $largest = $first;

        foreach ($other as $interval) {
            if ($interval->toMicroseconds() > $largest->toMicroseconds()) {
                $largest = $interval;
            }
        }

        return $largest;
    }
}
