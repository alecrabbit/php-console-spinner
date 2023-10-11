<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;

/**
 * @deprecated Will be removed
 */
final class LegacySignalProcessingProbeFactory implements \AlecRabbit\Spinner\Core\Legacy\ILegacySignalProcessingProbeFactory
{
    public function getProbe(): ILegacySignalProcessingLegacyProbe
    {
        return new LegacySignalProcessingProbe();
    }
}
