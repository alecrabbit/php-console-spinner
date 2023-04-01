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
                output: $output, // FIXME use ~ $defaults->get...
                cursor: new Cursor($output, OptionCursor::HIDDEN), // FIXME use ~ $defaults->get...
                timer: new Timer(), // FIXME use ~ $defaults->get...
                driverConfig: $this->driverConfig,
            );
    }

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder
    {
        $this->driverConfig = $driverConfig;
        return $this;
    }
}
