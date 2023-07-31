<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Solver;

interface ISolver
{
    public function solve(): mixed;
}
