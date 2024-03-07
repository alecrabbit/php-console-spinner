<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IDriverInfoPrinter
{
    public function print(IDriver $driver): void;
}
