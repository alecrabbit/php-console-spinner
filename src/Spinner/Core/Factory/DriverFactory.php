<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeltaTimerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;

final class DriverFactory implements IDriverFactory
{
    public function __construct(
        protected IDriverConfig $driverConfig,
        protected IDriverBuilder $driverBuilder,
        protected IIntervalFactory $intervalFactory,
        protected IDeltaTimerFactory $timerFactory,
        protected ISequenceStateWriterFactory $sequenceStateWriterFactory,
    ) {
    }

    public function create(): IDriver
    {
        return
            $this->driverBuilder
                ->withSequenceStateWriter(
                    $this->sequenceStateWriterFactory->create()
                )
                ->withDeltaTimer(
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
