<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;

final class DriverProvider implements IDriverProvider
{
    public function __construct(
        protected IDriver $driver,
    ) {
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }
}
