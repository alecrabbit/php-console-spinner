<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISolver
{
    /**
     * @throws InvalidArgumentException
     */
    public function solve(): mixed;
}
