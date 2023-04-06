<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

interface IDriverBuilder
{
    public function build(): IDriver;

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder;

    public function withAuxConfig(IAuxConfig $auxConfig): IDriverBuilder;
}
