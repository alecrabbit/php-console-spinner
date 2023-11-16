<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IGeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;

final readonly class GeneralConfigFactory implements IGeneralConfigFactory
{
    public function __construct(
        protected IRunMethodModeSolver $runMethodModeSolver,
        protected IGeneralConfigBuilder $generalConfigBuilder,
    ) {
    }

    public function create(): IGeneralConfig
    {
        return
            $this->generalConfigBuilder
                ->withRunMethodMode(
                    $this->runMethodModeSolver->solve()
                )
                ->build()
        ;
    }
}
