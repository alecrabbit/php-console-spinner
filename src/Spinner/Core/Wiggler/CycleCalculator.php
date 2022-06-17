<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Interval;

final class CycleCalculator
{
    protected const MILLISECONDS = 1000;

    public static function calculate(?IInterval $preferredInterval, ?IInterval $interval): int
    {
        if (null === $preferredInterval && null === $interval) {
            return 0;
        }
        if (null === $preferredInterval) {
            $preferredInterval = self::defaultInterval();
        }
        if (null === $interval) {
            $interval = self::defaultInterval();
        }
        $i = (int)floor($interval->toSeconds() / $preferredInterval->toSeconds()) - 1;
        if(0 > $i) {
            $i = 0;
        }
        return $i;
    }

    private static function defaultInterval(): Interval
    {
        return new Interval(self::MILLISECONDS);
    }
}
