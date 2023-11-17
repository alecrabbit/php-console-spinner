<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IDriverProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\DriverProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverProviderFactory;

abstract class ADriverProviderFactory implements IDriverProviderFactory
{
    public function __construct(
        protected IDriverFactory $driverFactory,
        protected IDriverSetup $driverSetup,
    ) {
    }

    public function create(): IDriverProvider
    {
        $driver = $this->driverFactory->create();

        $driverProvider =
            new DriverProvider(
                driver: $driver,
            );

        $this->driverSetup->setup($driver);

        return $driverProvider;
    }
}
