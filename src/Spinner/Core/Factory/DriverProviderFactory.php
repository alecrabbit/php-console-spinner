<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;

// FIXME (2023-10-23 13:0) [Alec Rabbit]: this implementation doing too much [a3f8554e-1dc8-41a9-abdf-39a6386a490b]
final class DriverProviderFactory implements IDriverProviderFactory
{
    public function __construct(
        protected IDriverFactory $driverFactory,
        protected IDriverLinker $linker,
    ) {
    }

    public function create(): IDriverProvider
    {
        return
            new DriverProvider(
                driver: $this->createDriver(),
            );
    }

    protected function createDriver(): IDriver
    {
        $driver = $this->driverFactory->create();

        $driver->initialize();

        $this->linker->link($driver);

        return $driver;
    }
}
