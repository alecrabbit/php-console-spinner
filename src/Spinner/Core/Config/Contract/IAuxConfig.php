<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

interface IAuxConfig extends IConfigElement
{
    public function getRunMethodMode(): RunMethodMode;

    /**
     * @deprecated Rely on RunMethodMode
     */
    public function getLoopAvailabilityMode(): LoopAvailabilityMode;

    public function getNormalizerMethodMode(): NormalizerMethodMode;
}
