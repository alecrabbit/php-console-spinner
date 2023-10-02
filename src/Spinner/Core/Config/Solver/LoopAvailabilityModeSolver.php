<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\ILoopAvailabilityModeSolver;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Probes;

final class LoopAvailabilityModeSolver implements ILoopAvailabilityModeSolver
{
    /** @inheritDoc */
    public function solve(): LoopAvailabilityMode
    {
        return
            $this->isLoopAvailable()
                ? LoopAvailabilityMode::AVAILABLE
                : LoopAvailabilityMode::NONE;
    }

    private function isLoopAvailable(): bool
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
