<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;

class AutoStartModeSolver implements IAutoStartModeSolver
{

    public function solve(): AutoStartMode
    {
        // TODO: Implement solve() method.
        throw new \RuntimeException('Not implemented.');
    }
}
