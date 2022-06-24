<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\HasInterval;

interface IIntervalComponent extends HasInterval
{
    public function accept(IIntervalVisitor $intervalVisitor): void;

    public function getIntervalComponents(): iterable;
}
