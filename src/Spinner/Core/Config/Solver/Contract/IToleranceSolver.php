<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Contract\ITolerance;

interface IToleranceSolver extends ISolver
{
    public function solve(): ITolerance;
}
