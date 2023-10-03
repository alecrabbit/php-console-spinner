<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;

final class AuxConfigFactory implements IAuxConfigFactory
{
    public function __construct(
        protected IRunMethodModeSolver $runMethodModeSolver,
        protected INormalizerMethodModeSolver $normalizerMethodModeSolver,
        protected IAuxConfigBuilder $auxConfigBuilder,
    ) {
    }

    public function create(): IAuxConfig
    {
        return
            $this->auxConfigBuilder
                ->withRunMethodMode(
                    $this->runMethodModeSolver->solve()
                )
                ->withNormalizerMethodMode(
                    $this->normalizerMethodModeSolver->solve()
                )
                ->build()
        ;
    }
}
