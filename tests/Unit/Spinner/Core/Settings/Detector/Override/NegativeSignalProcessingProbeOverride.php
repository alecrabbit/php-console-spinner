<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;

class NegativeSignalProcessingProbeOverride implements ISignalProcessingProbe
{
    public static function isSupported(): bool
    {
        return false;
    }
}
