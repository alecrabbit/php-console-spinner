<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

/**
 * @deprecated
 */
interface ILegacyStaticProbeFactory
{
    public function createProbe(): IStaticProbe;
}
