<?php

declare(strict_types=1);

// 03.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use Closure;

interface IDriverBuilder
{
    public function build(): IDriver;

    public function withIntervalCallback(Closure $fn): IDriverBuilder;

    public function withTimer(ITimer $timer): IDriverBuilder;

    public function withDriverOutput(IDriverOutput $driverOutput): IDriverBuilder;
}
