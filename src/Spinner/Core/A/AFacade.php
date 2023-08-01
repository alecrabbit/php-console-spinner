<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use Psr\Container\ContainerInterface;

abstract class AFacade
{
    protected static ?ContainerInterface $container = null;

    /**
     * @codeCoverageIgnore
     */
    final protected function __construct()
    {
        // No instances of this class are allowed.
    }

    protected static function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            self::$container = self::createContainer();
        }
        return self::$container;
    }

    private static function createContainer(): ContainerInterface
    {
        $registry = DefinitionRegistry::getInstance();

        $class = ContainerFactory::class;

        return (new $class($registry))->getContainer();
    }
}
