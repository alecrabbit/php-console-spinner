<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Solver;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

interface IRunMethodModeSolver extends ISolver
{
    public function solve(): RunMethodMode;
}
