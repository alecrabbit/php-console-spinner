<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;

final readonly class DriverConfigFactory implements IDriverConfigFactory
{
    public function __construct(
        protected ILinkerModeSolver $linkerModeSolver,
        protected IDriverConfigBuilder $driverConfigBuilder,
    ) {
    }


    public function create(): IDriverConfig
    {
        return
            $this->driverConfigBuilder
                ->withLinkerMode(
                    $this->linkerModeSolver->solve(),
                )
                ->build()
        ;
    }
}
