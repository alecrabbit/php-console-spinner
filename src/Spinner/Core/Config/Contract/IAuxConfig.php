<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

interface IAuxConfig
{
    public function getRunMethodMode(): RunMethodMode;

    public function getLoopAvailabilityMode(): LoopAvailabilityMode;

    public function getNormalizerMethodMode(): NormalizerMethodMode;
}
