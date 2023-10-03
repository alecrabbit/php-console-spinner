<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\LegacySignalProcessingProbe;

final class SignalProcessingProbeFactory implements Contract\ISignalProcessingProbeFactory
{
    public function getProbe(): ILegacySignalProcessingLegacyProbe
    {
        return new LegacySignalProcessingProbe();
    }
}
