<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\ILegacyDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

interface ILegacyDriverBuilder
{
    public function build(): ILegacyDriver;

    public function withDriverConfig(IDriverConfig $driverConfig): ILegacyDriverBuilder;

    public function withAuxConfig(IAuxConfig $auxConfig): ILegacyDriverBuilder;
}
