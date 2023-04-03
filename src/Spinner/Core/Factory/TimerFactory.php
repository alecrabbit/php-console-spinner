<?php
declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Timer;

final class TimerFactory implements ITimerFactory
{
    public function createTimer(): ITimer
    {
        return new Timer();
    }
}