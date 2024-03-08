<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract\Factory;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IMemoryReportSetupFactory
{
    public function create(IDriver $driver): IMemoryReportLoopSetup;
}
