<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;

interface ICursorVisibilityModeSolver extends ISolver
{
    public function solve(): CursorVisibilityMode;
}
