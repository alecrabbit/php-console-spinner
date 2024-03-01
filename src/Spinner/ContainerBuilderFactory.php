<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\ContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\DefinitionRegistry;

final readonly class ContainerBuilderFactory implements IContainerBuilderFactory
{
    public function create(): IContainerBuilder
    {
        return new ContainerBuilder(
            registry: $this->getDefinitionRegistry(),
            factories: $this->getContainerFactoryStore(),
        );
    }

    private function getDefinitionRegistry(): Container\Contract\IDefinitionRegistry
    {
        return DefinitionRegistry::getInstance();
    }

    protected function getContainerFactoryStore(): ContainerFactoryStore
    {
        $containerFactoryStore = new ContainerFactoryStore();

        foreach ($this->createFactories() as $factory) {
            $containerFactoryStore->add($factory);
        }

        return $containerFactoryStore;
    }

    private function createFactories(): \Traversable
    {
        foreach (ContainerFactories::load() as $factoryClass) {
            yield new $factoryClass();
        }
    }
}
