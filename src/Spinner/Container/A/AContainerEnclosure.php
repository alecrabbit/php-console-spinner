<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use Psr\Container\ContainerInterface;

abstract class AContainerEnclosure
{
    private static ?IContainer $container = null;

    /** @var class-string<IContainerFactory> */
    private static string $factory = ContainerFactory::class;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    protected static function useContainer(?ContainerInterface $container): void
    {
        if ($container instanceof IContainer) {
            self::$container = $container;
            return;
        }

        if ($container instanceof ContainerInterface) {
            self::$container = new ContainerAdapter($container);
            return;
        }

        self::$container = null;
    }

    public static function useContainerFactory(string $factoryClass): void
    {
        if (!is_subclass_of($factoryClass, IContainerFactory::class)) {
            throw new ContainerException(
                sprintf(
                    'Factory class %s must implement %s',
                    $factoryClass,
                    IContainerFactory::class
                )
            );
        }

        self::$factory = $factoryClass;
    }

    final protected static function getContainer(): IContainer
    {
        dump(__METHOD__);
        return self::$container ?? self::createContainer();
    }

    protected static function createContainer(): IContainer
    {
        $registry = DefinitionRegistry::getInstance();

        return (new (self::$factory)($registry))->create();
    }
}
