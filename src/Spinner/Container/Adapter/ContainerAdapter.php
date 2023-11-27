<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Adapter;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use Psr\Container\ContainerInterface;

final readonly class ContainerAdapter implements IContainer
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    /**
     * @inheritDoc
     *
     * @psalm-suppress MixedInferredReturnType
     */
    public function get(string $id)
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->container->get($id);
    }

    /** @inheritDoc */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
