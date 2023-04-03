<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Cursor;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Spinner\Core\Timer;
use LogicException;

final class DriverBuilder implements IDriverBuilder
{
    protected ?IDriverConfig $driverConfig = null;

    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected ITimerFactory $timerFactory,
        protected IOutputFactory $outputFactory,
        protected OptionCursor $cursorOption,
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
        $output = new StreamBufferedOutput(new ResourceStream(STDERR));
        return
            new Driver(
                output: $this->outputFactory->getOutput(),
                cursor: new Cursor($output, $this->cursorOption),
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
