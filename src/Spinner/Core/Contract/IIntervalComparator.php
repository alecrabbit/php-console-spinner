<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface IIntervalComparator
{
    public function smallest(IInterval $first, ?IInterval ...$other): IInterval;

    public function largest(IInterval $first, ?IInterval ...$other): IInterval;
}
