<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Builder\ServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\CircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;

final readonly class ServiceSpawnerFactory implements IServiceSpawnerFactory
{
    public function __construct(
        private IServiceSpawnerBuilder $spawnerBuilder = new ServiceSpawnerBuilder(),
        private ICircularDependencyDetector $circularDependencyDetector = new CircularDependencyDetector(),
    ) {
    }

    public function create(IContainer $container): IServiceSpawner
    {
        return
            $this->spawnerBuilder
                ->withContainer($container)
                ->withCircularDependencyDetector($this->circularDependencyDetector)
                ->build()
        ;
    }
}
