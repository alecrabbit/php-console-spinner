<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\ITimer;

interface ITimerBuilder
{
    public function build(): ITimer;
}
