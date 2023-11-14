<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

interface IServiceSpawner
{
    /**
     * @param IDefinition $serviceDefinition
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function spawn(IDefinition $serviceDefinition): object;
}
