<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

interface IDriverProvider
{
    public function getDriver(): IDriver;
}
