<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;

final class TimerFactory implements Contract\ITimerFactory
{
    public function __construct(
        protected ITimerBuilder $timerBuilder,
    ) {
    }

    public function create(): ITimer
    {
        return $this->timerBuilder->build();
    }
}
