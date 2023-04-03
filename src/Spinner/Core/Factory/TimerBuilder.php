<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Timer;

final class TimerBuilder implements ITimerBuilder
{
    public function build(): ITimer
    {
        return new Timer();
    }
}