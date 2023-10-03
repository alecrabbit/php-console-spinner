<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Probes;
use Traversable;

final class LoopAvailabilityDetector implements ILoopAvailabilityDetector
{
    /** @inheritDoc */
    public function loopIsAvailable(): bool
    {
        foreach ($this->loadProbes() as $probe) {
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Traversable<ILoopProbe>
     * @throws InvalidArgumentException
     */
    private function loadProbes(): Traversable
    {
        return Probes::load(ILoopProbe::class);
    }
}
