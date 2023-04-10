<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;

final class DriverFactory implements IDriverFactory
{
    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ITimerFactory $timerFactory,
        protected IDriverSetup $driverSetup,
        // TODO (2023-04-10 20:07) [Alec Rabbit]: inject config [64045a0f-da0f-4bed-94fd-8f178bdf9282]
    ) {
    }

    public function create(): IDriver
    {
        $driver = $this->buildDriver();

        $this->driverSetup
            ->enableInitialization(true) // TODO: Make it configurable [64045a0f-da0f-4bed-94fd-8f178bdf9282]
            ->enableAttacher(true) // TODO: Make it configurable [64045a0f-da0f-4bed-94fd-8f178bdf9282]
            ->setup($driver);

        return
            $driver;
    }

    private function buildDriver(): IDriver
    {
        return $this->driverBuilder
            ->withDriverOutput($this->driverOutputFactory->create())
            ->withTimer($this->timerFactory->create())
            ->build()
        ;
    }
}
