<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

interface IDriverMessagesSolver extends ISolver
{
    public function solve(): IDriverMessages;
}
