<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Contract\ISignalHandlersContainer;

interface ISignalHandlersContainerSolver extends ISolver
{
    public function solve(): ISignalHandlersContainer;
}
