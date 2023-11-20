<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;

abstract class AContainerEnclosure
{
    private static ?IContainer $container = null;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances allowed.
    }

    public static function useContainer(?ContainerInterface $container): void
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

    final protected static function getContainer(): IContainer
    {
        return self::$container ?? throw new ContainerException('Container is not set.');
    }
}
