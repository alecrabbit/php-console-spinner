<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;

abstract class AContainerEnclosure
{
    private static ?IContainer $container = null;

    /** @var class-string<IContainerFactory> */
    private static string $factoryClass = ContainerFactory::class;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    public static function useContainerFactory(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IContainerFactory::class)) {
            throw new ContainerException(
                sprintf(
                    'Factory class must implement [%s]. "%s" given.',
                    IContainerFactory::class,
                    $factoryClass,
                )
            );
        }

        self::$factoryClass = $factoryClass;
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
        return self::getFactory()->create();
    }

    private static function getFactory(): IContainerFactory
    {
        return new (self::$factoryClass)(self::getDefinitionRegistry());
    }

    private static function getDefinitionRegistry(): IDefinitionRegistry
    {
        return DefinitionRegistry::getInstance();
    }
}
