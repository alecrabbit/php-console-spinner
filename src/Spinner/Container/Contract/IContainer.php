<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

interface IContainer extends ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @template T of object
     *
     * @param class-string<T> $id
     *
     * @psalm-return T
     *
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function get(string $id);

    /** @inheritDoc */
    public function has(string $id): bool;
}
