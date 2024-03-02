<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Builder;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;

final class ContainerBuilder implements IContainerBuilder
{
    private ?IContainerFactory $factory = null;
    private ?IDefinitionRegistry $registry = null;

    public function build(): IContainer
    {
        if ($this->factory === null) {
            throw new ContainerException('Container factory is not set.');
        }

        if ($this->registry === null) {
            throw new ContainerException('Definition registry is not set.');
        }

        return $this->factory->create($this->registry);
    }

    public function withFactory(IContainerFactory $factory): IContainerBuilder
    {
        $clone = clone $this;
        $clone->factory = $factory;
        return $clone;
    }

    public function withRegistry(IDefinitionRegistry $registry): IContainerBuilder
    {
        $clone = clone $this;
        $clone->registry = $registry;
        return $clone;
    }
}