<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILoopAvailabilityModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\INormalizerMethodModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IRunMethodModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

class AuxConfigFactory implements IAuxConfigFactory
{
    public function __construct(
        protected IRunMethodModeDetector $runMethodModeDetector,
        protected ILoopAvailabilityModeDetector $loopAvailabilityModeDetector,
        protected INormalizerMethodModeDetector $normalizerMethodModeDetector,
    ) {
    }

    public function create(): IAuxConfig
    {
        return
            new AuxConfig(
                runMethodMode: $this->runMethodModeDetector->detect(),
                loopAvailabilityMode: $this->loopAvailabilityModeDetector->detect(),
                normalizerMethodMode: $this->normalizerMethodModeDetector->detect(),
            );
    }
}
