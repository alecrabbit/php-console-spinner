<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Rotor\WInterval;

final class CycleCalculator
{
    protected const MILLISECONDS = 1000;

    public static function calculate(?IWInterval $preferredInterval, ?IWInterval $interval): int
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
        $i = (int)floor($interval->toSeconds() / $preferredInterval->toSeconds());
        if (0 > $i) {
            $i = 0;
        }
        return $i;
    }

    private static function defaultInterval(): WInterval
    {
        return new WInterval(self::MILLISECONDS);
    }
}
