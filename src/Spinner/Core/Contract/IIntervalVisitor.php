<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

interface IIntervalVisitor
{
    public function visit(IntervalComponent $container): IInterval;
}
