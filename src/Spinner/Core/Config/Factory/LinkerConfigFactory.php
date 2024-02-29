<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILinkerModeSolver;

final readonly class LinkerConfigFactory implements ILinkerConfigFactory, IInvokable
{
    public function __construct(
        protected ILinkerModeSolver $linkerModeSolver,
        protected ILinkerConfigBuilder $linkerConfigBuilder,
    ) {
    }

    public function create(): ILinkerConfig
    {
        return $this->linkerConfigBuilder
            ->withLinkerMode(
                $this->linkerModeSolver->solve(),
            )
            ->build()
        ;
    }

    public function __invoke(): ILinkerConfig
    {
        return $this->create();
    }
}
