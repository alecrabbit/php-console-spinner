<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

final class AuxConfig implements Contract\IAuxConfig
{
    public function __construct(
        protected RunMethodMode $runMethodMode,
        protected LoopAvailabilityMode $loopAvailabilityMode,
        protected NormalizerMethodMode $normalizerMethodMode,
    ) {
    }

    public function getRunMethodMode(): RunMethodMode
    {
        return $this->runMethodMode;
    }

    public function getLoopAvailabilityMode(): LoopAvailabilityMode
    {
        return $this->loopAvailabilityMode;
    }

    public function getNormalizerMethodMode(): NormalizerMethodMode
    {
        return $this->normalizerMethodMode;
    }

}
