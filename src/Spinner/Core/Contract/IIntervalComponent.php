<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\HasInterval;

interface IIntervalComponent extends HasInterval
{
    public function acceptIntervalVisitor(IIntervalVisitor $intervalVisitor): void;

    public function acceptCycleVisitor(ICycleVisitor $cycleVisitor): void;

    public function getIntervalComponents(): iterable;

    public function setCycle(ICycle $cycle): void;
}
