<?php

declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\I;

interface HasInterval
{
    public function getInterval(): IInterval;
}
