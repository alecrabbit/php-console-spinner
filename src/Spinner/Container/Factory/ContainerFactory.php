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
    ) {
    }

    public function getContainer(): IContainer
    {
        return
            new Container(
                spawnerCreatorCb: static function (ContainerInterface $container): IServiceSpawner {
                    return
                        new ServiceSpawner($container);
                },
                definitions: $this->registry->load(),
            );
    }
}
