<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceObjectFactory
{
    public function create(mixed $value, IServiceDefinition $serviceDefinition): IService;
}
