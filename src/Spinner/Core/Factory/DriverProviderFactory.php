<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;

final class DriverProviderFactory implements IDriverProviderFactory
{
    public function __construct(
        protected IDriverFactory $driverFactory,
    ) {
    }

    public function create(): IDriverProvider
    {
        $driver = $this->createDriver();

        return
            new DriverProvider(
                driver: $driver,
            );
    }

    protected function createDriver(): IDriver
    {
        return $this->driverFactory->create();
    }
}
