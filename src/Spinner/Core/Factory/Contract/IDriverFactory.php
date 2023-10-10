<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

interface IDriverFactory
{
    public function create(): IDriver;
}
