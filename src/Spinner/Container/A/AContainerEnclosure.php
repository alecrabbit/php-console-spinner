<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;

abstract class AContainerEnclosure
{
    private static ?IContainer $container = null;

    /** @var class-string<IContainerBuilderFactory> */
    private static string $factoryClass = IContainerBuilderFactory::class;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    public static function useFactoryClass(string $class): void
    {
        self::assertClass($class);
        self::$factoryClass = $class;
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
        self::assertClass(self::$factoryClass);

        return (new (self::$factoryClass)())->create();
    }

    private static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IContainerBuilderFactory::class)) {
            throw new ContainerException(
                sprintf(
                    'Container builder class must implement [%s]. "%s" given.',
                    IContainerBuilderFactory::class,
                    $class,
                )
            );
        }
    }
}
