<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\A;

use AlecRabbit\Spinner\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;

abstract class AContainerEnclosure
{
    protected static ?ContainerInterface $container = null;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances of this class are allowed.
    }

    final protected static function getContainer(): ContainerInterface
    {
        return
            self::$container ?? throw new ContainerException('Container is not set.');
    }

    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }
}
