<?php

declare(strict_types=1);

// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;

final class DriverSetup implements IDriverSetup
{
    protected bool $initializationEnabled = false;
    protected bool $attacherEnabled = false;

    public function __construct(
        protected IDriverAttacher $attacher,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        if ($this->initializationEnabled) {
            $driver->initialize();
        }

        if ($this->attacherEnabled) {
            $this->attacher->attach($driver);
        }
    }

    public function enableInitialization(bool $enable): IDriverSetup
    {
        $this->initializationEnabled = $enable;
        return $this;
    }

    public function enableAttacher(bool $enable): IDriverSetup
    {
        $this->attacherEnabled = $enable;
        return $this;
    }
}
