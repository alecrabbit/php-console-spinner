<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Builder\ServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\CircularDependencyDetector;
use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;

final readonly class ContainerFactory implements IContainerFactory
{
    public function __construct(
        private IDefinitionRegistry $definitionRegistry,
        private IServiceSpawnerBuilder $spawnerBuilder = new ServiceSpawnerBuilder(),
        private ICircularDependencyDetector $circularDependencyDetector = new CircularDependencyDetector(),
    ) {
    }

    public function create(): IContainer
    {
        return
            new Container(
                spawnerBuilder: $this->spawnerBuilder,
                circularDependencyDetector: $this->circularDependencyDetector,
                definitions: $this->definitionRegistry->load(),
            );
    }
}
