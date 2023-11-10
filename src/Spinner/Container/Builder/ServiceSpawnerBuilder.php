<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Builder;

use AlecRabbit\Spinner\Container\Contract\IContainer;
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

    public function withContainer(IContainer $container): IServiceSpawnerBuilder
    {
        $clone = clone $this;
        $clone->container = $container;
        return $clone;
    }

    public function build(): IServiceSpawner
    {
        $this->validate();

        return
            new ServiceSpawner($this->container);
    }

    private function validate(): void
    {
        match (true) {
            $this->container === null => throw new LogicException('Container is not set.'),
            default => null,
        };
    }
}
