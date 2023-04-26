<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

interface IDriverBuilder
{
    public function build(): IDriver;

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder;
}
