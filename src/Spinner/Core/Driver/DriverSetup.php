<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;

final readonly class DriverSetup implements IDriverSetup
{
    public function __construct(
        private IDriverLinker $driverLinker,
        private ISignalHandlingSetup $signalHandlingSetup,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        $this->driverLinker->link($driver);

        $this->signalHandlingSetup->setup($driver);

        $driver->initialize();
    }
}
