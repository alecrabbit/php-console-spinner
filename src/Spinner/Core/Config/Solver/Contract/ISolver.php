<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface ISolver
{
    /**
     * @throws InvalidArgument
     * @throws LogicException
     */
    public function solve(): mixed;
}
