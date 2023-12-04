<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Traversable;

interface IDefinitionRegistry
{
    /**
     * @return Traversable<string, IServiceDefinition>
     */
    public function load(): Traversable;

    public function bind(IServiceDefinition ...$serviceDefinitions): void;
}
