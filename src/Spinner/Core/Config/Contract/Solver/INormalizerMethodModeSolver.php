<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Solver;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;

interface INormalizerMethodModeSolver extends ISolver
{
    public function solve(): NormalizerMethodMode;
}
