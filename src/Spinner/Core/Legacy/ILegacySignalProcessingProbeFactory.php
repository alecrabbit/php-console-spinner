<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Contract\IProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;

/**
 * @deprecated Will be removed
 */
interface ILegacySignalProcessingProbeFactory extends IProbeFactory
{
    public function getProbe(): ILegacySignalProcessingLegacyProbe;
}
