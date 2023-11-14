<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceSpawnerBuilder
{
    public function withContainer(IContainer $container): IServiceSpawnerBuilder;

    public function withCircularDependencyDetector(ICircularDependencyDetector $detector): IServiceSpawnerBuilder;

    public function build(): IServiceSpawner;
}
