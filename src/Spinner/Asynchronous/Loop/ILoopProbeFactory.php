<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Exception\DomainException;

interface ILoopProbeFactory extends IProbeFactory
{
    public function getProbe(): ILoopProbe;
}
