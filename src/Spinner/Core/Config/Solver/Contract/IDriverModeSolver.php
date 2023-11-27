<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;

interface IDriverModeSolver extends ISolver
{
    public function solve(): DriverMode;
}
