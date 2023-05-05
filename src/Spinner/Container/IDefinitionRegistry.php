<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use Traversable;

interface IDefinitionRegistry
{
    public static function getInstance(): IDefinitionRegistry;

    public function getDefinitions(): Traversable;

    public function register(string $typeId, object|callable|string $definition): void;
}
