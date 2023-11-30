<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IIsStorableSolver;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;

final readonly class ServiceIsStorableSolver implements IIsStorableSolver
{
    public function isStorable(IServiceDefinition $definition): bool
    {
        return $definition->getOptions() === IServiceDefinition::SINGLETON;
    }
}
