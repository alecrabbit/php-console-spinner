<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Spinner\Core\Container\Contract;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

interface IContainer extends ContainerInterface
{
    /** @inheritdoc */
    public function get(string $id): object;

    /** @inheritdoc */
    public function has(string $id): bool;

    /**
     * Adds definition to the container.
     *
     * @param string $id Identifier of the entry to add.
     * @param callable|object|string $definition Definition of the entry to add.
     *
     * @throws ContainerExceptionInterface If definition for **this** identifier is already registered.
     */
    public function add(string $id, callable|object|string $definition): void;

    /**
     * Removes definition and service(if any) from the container.
     *
     * @param string $id Identifier of the entry to remove.
     *
     * @throws NotFoundExceptionInterface No entry was found for **this** identifier.
     */
    public function remove(string $id): void;

    /**
     * Replaces definition and service(if any) in the container.
     *
     * @param string $id Identifier of the entry to replace.
     * @param callable|object|string $definition Definition of the entry to replace.
     *
     * @throws NotFoundExceptionInterface No entry was found for **this** identifier.
     */
    public function replace(string $id, callable|object|string $definition): void;
}