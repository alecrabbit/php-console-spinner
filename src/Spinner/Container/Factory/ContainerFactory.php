<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;

final readonly class ContainerFactory implements IContainerFactory
{
    public function __construct(
        private IServiceSpawnerFactory $spawnerFactory = new ServiceSpawnerFactory(),
    ) {
    }

    public function create(IDefinitionRegistry $definitionRegistry): IContainer
    {
        return new Container(
            spawnerFactory: $this->spawnerFactory,
            definitions: $definitionRegistry->load(),
        );
    }

    public function isSupported(): bool
    {
        return true;
    }
}
