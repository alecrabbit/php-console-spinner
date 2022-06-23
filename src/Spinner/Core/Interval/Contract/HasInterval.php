<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Interval\Contract;

interface HasInterval
{
    public function getInterval(): IInterval;
}
