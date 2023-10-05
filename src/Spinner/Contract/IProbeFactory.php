<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

/**
 * @deprecated
 */
interface IProbeFactory
{
    public function getProbe(): ILegacyProbe;
}
