<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;

final class DriverFactory implements IDriverFactory
{
    /**
     * @deprecated Do not use this property. Refactor. This factory should return new instance every time.
     */
    private static ?IDriver $driver = null;

    public function __construct(
        protected IIntervalFactory $intervalFactory,
        protected IDriverBuilder $driverBuilder,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ISignalHandlersSetupFactory $signalHandlersSetupFactory,
        protected ITimerFactory $timerFactory,
        protected IDriverSetup $driverSetup,
        protected ILegacyDriverSettings $driverSettings,
        protected IDriverConfig $driverConfig,
    ) {
    }

    public function create(): IDriver
    {
        // TODO (2023-10-06 20:04) [Alec Rabbit]: refactor this factory to return new instance every time
        if (self::$driver === null) {
            self::$driver = $this->buildDriver();

            $this->driverSetup
                ->enableInitialization($this->driverSettings->isInitializationEnabled())
                ->enableLinker($this->driverSettings->isLinkerEnabled())
                ->setup(self::$driver)
            ;

            $this->signalHandlersSetupFactory
                ->create()
                ->setup(self::$driver)
            ;
        }

        return self::$driver;
    }

    private function buildDriver(): IDriver
    {
        $output = $this->driverOutputFactory->create();

        $timer = $this->timerFactory->create();

        $interval = $this->intervalFactory->createStill();

        return
            $this->driverBuilder
                ->withDriverOutput($output)
                ->withTimer($timer)
                ->withDriverSettings($this->driverSettings)
                ->withInitialInterval($interval)
                ->withDriverConfig($this->driverConfig)
                ->build()
        ;
    }
}
