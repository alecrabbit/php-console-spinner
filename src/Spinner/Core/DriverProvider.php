<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;

final readonly class DriverProvider implements IDriverProvider
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
