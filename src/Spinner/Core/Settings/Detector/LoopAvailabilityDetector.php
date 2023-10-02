<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Probes;

final class LoopAvailabilityDetector implements ILoopAvailabilityDetector
{
    public function loopIsAvailable(): bool
    {
        foreach ($this->loadProbes() as $probe) {
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }

    private function loadProbes(): \Traversable
    {
        return Probes::load(ILoopProbe::class);
    }
}
