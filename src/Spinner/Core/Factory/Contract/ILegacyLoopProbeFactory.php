<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Probe\ILegacyStaticProbeFactory;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;

/**
 * @deprecated
 */
interface ILegacyLoopProbeFactory extends ILegacyStaticProbeFactory
{
    public function createProbe(): ILoopProbe;
}
