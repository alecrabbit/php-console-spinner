<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Psr\Container\ContainerInterface;

interface IServiceSpawnerFactory
{
    public function create(IContainer $container): IServiceSpawner;
}
