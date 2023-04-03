<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerFactory;
use LogicException;

final class DriverBuilder implements IDriverBuilder
{
    protected ?IDriverConfig $driverConfig = null;

    public function __construct(
        protected ITimerFactory $timerFactory,
        protected IOutputFactory $outputFactory,
        protected ICursorFactory $cursorFactory,
    ) {
    }

    public function build(): IDriver
    {
        if (null === $this->driverConfig) {
            throw new LogicException(
                sprintf('[%s]: Property $driverConfig is not set.', __CLASS__)
            );
        }
        return $this->createDriver();
    }

    private function createDriver(): Driver
    {
        return
            new Driver(
                output: $this->outputFactory->getOutput(),
                cursor: $this->cursorFactory->createCursor(),
                timer: $this->timerFactory->createTimer(),
                driverConfig: $this->driverConfig,
            );
    }

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder
    {
        $this->driverConfig = $driverConfig;
        return $this;
    }
}
