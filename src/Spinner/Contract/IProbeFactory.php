<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IProbeFactory
{
    public function getProbe(): ILegacyProbe;
}
