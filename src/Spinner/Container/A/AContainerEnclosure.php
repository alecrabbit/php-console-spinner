<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\ContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\ContainerFactories;

abstract class AContainerEnclosure
{
    private static ?IContainer $container = null;

    /** @var class-string<IContainerBuilder> */
    private static string $containerBuilderClass = ContainerBuilder::class;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    public static function useContainerBuilderClass(string $class): void
    {
        if (!is_subclass_of($class, IContainerBuilder::class)) {
            throw new ContainerException(
                sprintf(
                    'Container builder class must implement [%s]. "%s" given.',
                    IContainerBuilder::class,
                    $class,
                )
            );
        }
        self::$containerBuilderClass = $class;
    }

    final protected static function getContainer(): IContainer
    {
        if (self::$container === null) {
            self::$container = self::createContainer();
        }
        return self::$container;
    }

    /**
     * This method is used to override container instance in tests.
     */
    final protected static function setContainer(?IContainer $container): void
    {
        self::$container = $container;
    }

    private static function createContainer(): IContainer
    {
        return self::getBuilder()->build();
    }

    private static function getBuilder(): IContainerBuilder
    {
        return new (self::$containerBuilderClass)(
            DefinitionRegistry::getInstance(),
            new ContainerFactoryStore(
                self::getFactories(),
            ),
        );
    }

    private static function getFactories(): \ArrayObject
    {
        $instances = new \ArrayObject();
        foreach (ContainerFactories::load() as $factoryClass) {
            $instances->append(new $factoryClass());
        }
        return $instances;
    }
}
