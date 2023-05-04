<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;

final class DriverSingletonFactory implements IDriverSingletonFactory
{
    private static ?IDriver $driver = null;

    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ITimerFactory $timerFactory,
        protected IDriverSetup $driverSetup,
        protected IDriverSettings $driverSettings,
        protected ILoopSetupFactory $loopSetupFactory,
    ) {
    }

    public function getDriver(): IDriver
    {
        if (self::$driver === null) {
            self::$driver = $this->buildDriver();

            $this->driverSetup
                ->enableInitialization($this->driverSettings->isInitializationEnabled())
                ->enableLinker($this->driverSettings->isLinkerEnabled())
                ->setup(self::$driver)
            ;

            $this->loopSetupFactory->create()->setup(self::$driver);
        }

        return self::$driver;
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
