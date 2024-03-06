<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilderFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;

abstract class AContainerEnclosure
{
    private const EMPTY = null;

    private static ?IContainer $container = null;

    /** @var null|class-string<IContainerBuilderFactory> */
    private static ?string $factoryClass = self::EMPTY;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    public static function useFactoryClass(string $class): void // method name [2d254244-98d1-47b2-83c3-f761ad83f042]
    {
        self::assertClass($class);
        self::$factoryClass = $class;
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

    final protected static function getContainer(): IContainer
    {
        if (self::$container === null) {
            self::$container = self::getContainerBuilder()->build();
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

    private static function getContainerBuilder(): IContainerBuilder
    {
        if (self::$factoryClass === self::EMPTY) {
            throw new ContainerException(
                sprintf(
                    'Container builder factory class must be set. Use %s method for that.',
                    static::class . '::useFactoryClass()' // method name [2d254244-98d1-47b2-83c3-f761ad83f042]
                )
            );
        }

        self::assertClass(self::$factoryClass);

        return (new (self::$factoryClass)())->create();
    }
}
