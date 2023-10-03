<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Probes;
use Traversable;

final class SignalProcessingDetector implements ISignalProcessingDetector
{

    /** @inheritDoc */
    public function isSupported(): bool
    {
        foreach ($this->loadProbes() as $probe) {
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Traversable<ISignalProcessingProbe>
     * @throws InvalidArgumentException
     */
    private function loadProbes(): Traversable
    {
        return Probes::load(ISignalProcessingProbe::class);
    }
}
