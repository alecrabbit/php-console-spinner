<?php

declare(strict_types=1);

// 10.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\ITimer;

interface ITimerFactory
{
    public function create(): ITimer;
}
