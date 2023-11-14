<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Traversable;

interface IDefinitionRegistry
{
    public function load(): Traversable;

    /**
     * @param string $id
     * @param object|callable|string $definition
     * @param int $options Ignored for now
     */
    public function bind(string $id, object|callable|string $definition, int $options = 0): void;
}
