<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;

interface ISignalHandlersModeSolver extends ISolver
{
    public function solve(): SignalHandlersMode;
}
