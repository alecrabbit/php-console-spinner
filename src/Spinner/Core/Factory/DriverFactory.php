<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;

final class DriverFactory implements IDriverFactory
{
    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ITimerFactory $timerFactory,
    ) {
    }

    public function create(): IDriver
    {
        return
            $this->driverBuilder
                ->withDriverOutput($this->driverOutputFactory->create())
                ->withTimer($this->timerFactory->create())
                ->build()
        ;
    }
}
