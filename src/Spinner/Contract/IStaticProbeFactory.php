<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IStaticProbeFactory
{
    public function createProbe(): IStaticProbe;
}
