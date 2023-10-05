<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;

final class DriverSetup implements IDriverSetup
{
    private bool $initializationEnabled = false;
    private bool $linkerEnabled = false;

    public function __construct(
        protected IDriverLinker $linker,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        if ($this->initializationEnabled) {
            $driver->initialize();
        }

        if ($this->linkerEnabled) {
            $this->linker->link($driver);
        }
    }

    public function enableInitialization(bool $enable): IDriverSetup
    {
        $this->initializationEnabled = $enable;
        return $this;
    }

    public function enableLinker(bool $enable): IDriverSetup
    {
        $this->linkerEnabled = $enable;
        return $this;
    }
}
