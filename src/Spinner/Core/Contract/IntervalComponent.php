<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\HasInterval;

interface IntervalComponent extends HasInterval
{
    public function updateInterval(IIntervalVisitor $intervalVisitor): void;

    public function getIntervalComponents(): iterable;
}
