<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRevolverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IToleranceSolver;

final readonly class RevolverConfigFactory implements IRevolverConfigFactory
{
    public function __construct(
        protected IToleranceSolver $toleranceSolver,
        protected IRevolverConfigBuilder $revolverConfigBuilder,
    ) {
    }

    public function create(): IRevolverConfig
    {
        return $this->revolverConfigBuilder
            ->withTolerance(
                $this->toleranceSolver->solve()
            )
            ->build()
        ;
    }
}
