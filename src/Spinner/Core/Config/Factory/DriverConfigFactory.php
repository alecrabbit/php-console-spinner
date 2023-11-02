<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final readonly class DriverConfigFactory implements IDriverConfigFactory
{
    public function __construct(
        protected IDriverConfigBuilder $driverConfigBuilder,
    ) {
    }


    public function create(): IDriverConfig
    {
        return
            $this->driverConfigBuilder
                ->build()
        ;
    }
}
