<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IAuxConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IAuxConfig;

    public function withRunMethodMode(RunMethodMode $runMethodMode): IAuxConfigBuilder;

    public function withLoopAvailabilityMode(LoopAvailabilityMode $loopAvailabilityMode): IAuxConfigBuilder;

    public function withNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): IAuxConfigBuilder;
}
