<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

final class CycleCalculator
{
    public static function calculate(IInterval $preferredInterval, IInterval $interval): int
    {
        $i = (int)floor($interval->toMilliseconds() / $preferredInterval->toMilliseconds());
        if (0 > $i) {
            $i = 0;
        }
        return $i;
    }
}
