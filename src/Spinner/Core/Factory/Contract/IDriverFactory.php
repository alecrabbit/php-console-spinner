<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;

interface IDriverFactory
{
    public function getDriver(): IDriver;
}
