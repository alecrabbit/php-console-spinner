<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Legacy\Terminal\Contract\ITerminalLegacyProbe;

/**
 * @deprecated
 */
interface ILegacyTerminalProbeFactory extends IProbeFactory
{
    public function getProbe(): ITerminalLegacyProbe;
}
