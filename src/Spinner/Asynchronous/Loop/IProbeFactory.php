<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Contract\IProbe;

interface IProbeFactory
{
    public function getProbe(): IProbe;
}
