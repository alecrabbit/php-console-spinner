<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;

interface IExecutionModeSolver extends ISolver
{
    public function solve(): ExecutionMode;
}
