<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;

interface ISolver
{
    /**
     * @throws InvalidArgument
     */
    public function solve(): mixed;
}
