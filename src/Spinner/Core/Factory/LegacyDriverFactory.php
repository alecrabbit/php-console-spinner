<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;

/**
 * @deprecated
 */
final class LegacyDriverFactory implements IDriverFactory
{
    public function __construct(
        protected IIntervalFactory $intervalFactory,
        protected IDriverBuilder $driverBuilder,
        protected IDriverOutputFactory $driverOutputFactory,
        protected ISignalHandlersSetupFactory $signalHandlersSetupFactory,
        protected ITimerFactory $timerFactory,
        protected IDriverSetup $driverSetup,
    ) {
    }

    public function create(): IDriver
    {
        $driver = $this->buildDriver();

        $this->driverSetup
            ->setup($driver)
        ;

        $this->signalHandlersSetupFactory
            ->create()
            ->setup($driver)
        ;

        return $driver;
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
                ->withInitialInterval($interval)
                ->build()
        ;
    }
}
