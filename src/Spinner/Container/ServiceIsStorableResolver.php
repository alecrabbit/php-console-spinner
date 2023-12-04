<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IIsStorableResolver;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;

final readonly class ServiceIsStorableResolver implements IIsStorableResolver
{
    public function isStorable(IServiceDefinition $definition): bool
    {
        return $definition->getOptions() === IServiceDefinition::SINGLETON;
    }
}
