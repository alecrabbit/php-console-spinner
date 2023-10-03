<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalLegacyProbe;

interface ITerminalProbeFactory extends IProbeFactory
{
    public function getProbe(): ITerminalLegacyProbe;
}
