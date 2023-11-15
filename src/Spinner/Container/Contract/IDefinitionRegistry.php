<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Traversable;

interface IDefinitionRegistry
{
    /**
     * @return Traversable<string|int, IServiceDefinition>
     */
    public function load(): Traversable;

    /**
     * @param string|IServiceDefinition $id
     * @param object|callable|class-string|null $definition
     * @param int $options
     */
    public function bind(
        string|IServiceDefinition $id,
        callable|object|string $definition = null,
        int $options = 0
    ): void;
}
