<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;

interface IStylingMethodModeSolver extends ISolver
{
    public function solve(): StylingMethodMode;
}
