<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;

final class DriverFactory implements IDriverFactory
{
    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IIntervalFactory $intervalFactory,
        protected IDriverOutputFactory $driverOutputFactory,
        protected IDeltaTimerFactory $timerFactory,
        protected IDriverConfig $driverConfig,
    ) {
    }

    public function create(): IDriver
    {
        return
            $this->driverBuilder
                ->withDriverOutput(
                    $this->driverOutputFactory->create()
                )
                ->withTimer(
                    $this->timerFactory->create()
                )
                ->withInitialInterval(
                    $this->intervalFactory->createStill()
                )
                ->withDriverConfig($this->driverConfig)
                ->build()
        ;
    }
}
