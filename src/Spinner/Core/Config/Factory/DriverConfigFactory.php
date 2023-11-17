<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;

final readonly class DriverConfigFactory implements IDriverConfigFactory
{
    public function __construct(
        protected IDriverConfigBuilder $driverConfigBuilder,
        protected IDriverMessagesSolver $driverMessagesSolver,
    ) {
    }

    public function create(): IDriverConfig
    {
        return
            $this->driverConfigBuilder
                ->withDriverMessages(
                    $this->driverMessagesSolver->solve()
                )
                ->build()
        ;
    }
}
