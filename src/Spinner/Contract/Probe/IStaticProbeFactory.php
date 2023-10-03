<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

interface IStaticProbeFactory
{
    public function createProbe(): IStaticProbe;
}
