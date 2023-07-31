<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Detector;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;

interface ILoopAvailabilityModeDetector extends IDetector
{
    public function detect(): LoopAvailabilityMode;
}
