<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

interface IDriverSetup
{
    public function setup(IDriver $driver): void;
}
