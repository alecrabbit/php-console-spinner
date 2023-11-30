<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IIsStorableResolver
{
    public function isStorable(IServiceDefinition $definition): bool;
}
