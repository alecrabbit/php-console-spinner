<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Builder;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;

final readonly class ContainerBuilder implements IContainerBuilder
{
    public function __construct(
        private IDefinitionRegistry $registry,
        private IContainerFactoryStore $factories,
    ) {
    }

    public function build(): IContainer
    {
        foreach ($this->factories as $factory) {
            if ($factory instanceof IContainerFactory && $factory->isSupported()) {
                return $factory->create($this->registry);
            }
        }

        throw new ContainerException('No supported container factory found.');
    }
}
