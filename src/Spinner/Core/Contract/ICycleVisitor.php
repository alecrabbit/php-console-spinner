<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

interface ICycleVisitor
{
    public function visit(IIntervalComponent $container): void;
}
