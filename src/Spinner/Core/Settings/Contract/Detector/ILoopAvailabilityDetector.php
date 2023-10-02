<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

interface ILoopAvailabilityDetector
{
    public function loopIsAvailable(): bool;
}
