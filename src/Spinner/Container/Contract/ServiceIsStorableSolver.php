<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

final readonly class ServiceIsStorableSolver implements IIsStorableSolver
{
    public function isStorable(IServiceDefinition $definition): bool
    {
        return $definition->getOptions() === IServiceDefinition::SINGLETON;
    }
}
