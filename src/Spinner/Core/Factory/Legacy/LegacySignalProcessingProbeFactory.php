<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\Factory\Contract;
use AlecRabbit\Spinner\Core\LegacySignalProcessingProbe;

/**
 * @deprecated Will be removed
 */
final class LegacySignalProcessingProbeFactory implements Contract\ILegacySignalProcessingProbeFactory
{
    public function getProbe(): ILegacySignalProcessingLegacyProbe
    {
        return new LegacySignalProcessingProbe();
    }
}
