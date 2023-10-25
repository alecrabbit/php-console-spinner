<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;

final readonly class DriverSetup implements IDriverSetup
{
    public function __construct(
        protected IDriverLinker $driverLinker,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        $driver->initialize();

        $this->driverLinker->link($driver);
    }
}
