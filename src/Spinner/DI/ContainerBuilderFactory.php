<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\DI;

use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\ContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use Traversable;

final readonly class ContainerBuilderFactory implements IContainerBuilderFactory
{
    public function create(): IContainerBuilder
    {
        $containerBuilder = new ContainerBuilder(
            registry: $this->getDefinitionRegistry(),
        );

        return $containerBuilder
            ->withFactory($this->findFactory());
    }

    private function getDefinitionRegistry(): IDefinitionRegistry
    {
        return DefinitionRegistry::getInstance();
    }

    private function createFactories(): Traversable
    {
        foreach (ContainerFactories::load() as $factoryClass) {
            yield new $factoryClass();
        }
    }

    private function findFactory(): IContainerFactory
    {
        foreach ($this->createFactories() as $factory) {
            if($factory->isSupported()) {
                return $factory;
            }
        }

        throw new ContainerException('No supported container factory found.');
    }
}
