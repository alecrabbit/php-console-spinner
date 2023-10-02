<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use RuntimeException;

class SignalHandlersModeSolver implements Contract\ISignalHandlersModeSolver
{

    public function solve(): SignalHandlersMode
    {
        // TODO: Implement solve() method.
        throw new RuntimeException('Not implemented.');
    }
}
