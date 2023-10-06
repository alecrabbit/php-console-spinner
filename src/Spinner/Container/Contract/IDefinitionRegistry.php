<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Traversable;

interface IDefinitionRegistry
{
    public function getDefinitions(): Traversable;

    public function bind(string $typeId, object|callable|string $definition): void;
}
