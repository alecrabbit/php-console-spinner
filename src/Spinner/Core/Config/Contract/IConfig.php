<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

interface IConfig
{
    public function getDriver(): IDriver;

    public function getLoopConfig(): ILoopConfig;

    public function getSpinnerConfig(): ISpinnerConfig;
}
