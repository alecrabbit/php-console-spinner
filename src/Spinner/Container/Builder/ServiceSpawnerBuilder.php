<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Builder;

use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceFactory;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class ServiceSpawnerBuilder implements IServiceSpawnerBuilder
{
    private ?IContainer $container = null;
    private ?ICircularDependencyDetector $circularDependencyDetector = null;
    private ?IServiceFactory $serviceObjectFactory = null;

    public function withContainer(IContainer $container): IServiceSpawnerBuilder
    {
        $clone = clone $this;
        $clone->container = $container;
        return $clone;
    }

    public function build(): IServiceSpawner
    {
        $this->validate();

        return new ServiceSpawner(
            container: $this->container,
            circularDependencyDetector: $this->circularDependencyDetector,
            serviceObjectFactory: $this->serviceObjectFactory,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->container === null => throw new LogicException('Container is not set.'),
            $this->circularDependencyDetector === null => throw new LogicException(
                'Circular dependency detector is not set.'
            ),
            $this->serviceObjectFactory === null => throw new LogicException('Service object factory is not set.'),
            default => null,
        };
    }

    public function withCircularDependencyDetector(ICircularDependencyDetector $detector): IServiceSpawnerBuilder
    {
        $clone = clone $this;
        $clone->circularDependencyDetector = $detector;
        return $clone;
    }

    public function withServiceObjectFactory(IServiceFactory $serviceObjectFactory): IServiceSpawnerBuilder
    {
        $clone = clone $this;
        $clone->serviceObjectFactory = $serviceObjectFactory;
        return $clone;
    }
}
