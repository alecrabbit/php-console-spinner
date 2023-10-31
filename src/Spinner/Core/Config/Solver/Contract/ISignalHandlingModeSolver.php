<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;

interface ISignalHandlingModeSolver extends ISolver
{
    public function solve(): SignalHandlingMode;
}
