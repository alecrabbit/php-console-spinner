<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\ServiceSpawner;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerFactory;
use Psr\Container\ContainerInterface;

final class ContainerFactory implements IContainerFactory
{
    private static ?IContainer $container = null;

    public function __construct(
        private readonly IDefinitionRegistry $registry,
    ) {
    }


    public function getContainer(): IContainer
    {
        if (self::$container === null) {
            self::$container = $this->createContainer();
        }
        return self::$container;
    }

    private function createContainer(): IContainer
    {
        return
            new Container(
                spawnerCreatorCb: static function (ContainerInterface $container): IServiceSpawner {
                    return new ServiceSpawner($container);
                },
                definitions: $this->registry->getDefinitions(),
            );
    }

}
