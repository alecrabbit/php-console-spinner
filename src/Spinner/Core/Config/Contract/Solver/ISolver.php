<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Solver;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISolver
{
    /**
     * @throws InvalidArgumentException
     */
    public function solve(): mixed;
}
