<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;

final class TimerBuilder implements ITimerBuilder
{
    public function build(): ITimer
    {
        return new Timer();
    }
}
