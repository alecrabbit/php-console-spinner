<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceSpawnerFactory
{
    public function create(IContainer $container): IServiceSpawner;
}
