<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use Psr\Container\ContainerInterface;

final readonly class ContainerFactory implements IContainerFactory
{
    public function __construct(
        private IDefinitionRegistry $registry,
        private ?\Closure $spawnerCreator = null,
    ) {
    }

    public function create(): IContainer
    {
        return
            new Container(
                spawnerCreatorCb: $this->getSpawnerCreator(),
                definitions: $this->registry->load(),
            );
    }

    protected function getSpawnerCreator(): \Closure
    {
        return
            $this->spawnerCreator
            ??
            static function (ContainerInterface $container): IServiceSpawner {
                return
                    new ServiceSpawner($container);
            };
    }
}
