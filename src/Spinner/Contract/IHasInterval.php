<?php

declare(strict_types=1);

// 19.06.22

namespace AlecRabbit\Spinner\Contract;

interface IHasInterval
{
    public function getInterval(): IInterval;
}
