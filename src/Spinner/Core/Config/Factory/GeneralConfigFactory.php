<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IGeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IExecutionModeSolver;

final readonly class GeneralConfigFactory implements IGeneralConfigFactory, IInvokable
{
    public function __construct(
        protected IExecutionModeSolver $executionModeSolver,
        protected IGeneralConfigBuilder $generalConfigBuilder,
    ) {
    }

    public function __invoke(): IGeneralConfig
    {
        return $this->create();
    }

    public function create(): IGeneralConfig
    {
        return $this->generalConfigBuilder
            ->withExecutionMode(
                $this->executionModeSolver->solve()
            )
            ->build()
        ;
    }
}
