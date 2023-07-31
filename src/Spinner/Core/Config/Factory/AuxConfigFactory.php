<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\ILoopAvailabilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\IRunMethodModeSolver;

class AuxConfigFactory implements IAuxConfigFactory
{
    public function __construct(
        protected IRunMethodModeSolver $runMethodModeSolver,
        protected ILoopAvailabilityModeSolver $loopAvailabilityModeSolver,
        protected INormalizerMethodModeSolver $normalizerMethodModeSolver,
    ) {
    }

    public function create(): IAuxConfig
    {
        return
            new AuxConfig(
                runMethodMode: $this->runMethodModeSolver->solve(),
                loopAvailabilityMode: $this->loopAvailabilityModeSolver->solve(),
                normalizerMethodMode: $this->normalizerMethodModeSolver->solve(),
            );
    }
}
