<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IAutoInstantiator;
use AlecRabbit\Spinner\Container\Exception\ContainerAlreadyRegistered;
use AlecRabbit\Spinner\Container\Exception\ContainerNotRegistered;
use Psr\Container\ContainerInterface;

final class AutoInstantiator implements IAutoInstantiator
{
    protected static ?ContainerInterface $container = null;
    public static function registerContainer(ContainerInterface $container): void
    {
        if (null !== self::$container) {
            throw new ContainerAlreadyRegistered('Container already registered.');
        }
        self::$container = $container;
    }

    public static function getContainer(): ContainerInterface
    {
        if(null === self::$container) {
            throw new ContainerNotRegistered('Container not registered.');
        }
        return self::$container;
    }
}
