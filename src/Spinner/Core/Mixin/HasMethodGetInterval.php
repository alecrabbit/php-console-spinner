<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

trait HasMethodGetInterval
{
    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
