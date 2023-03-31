<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IAutoInstantiator;
use AlecRabbit\Spinner\Container\Exception\ContainerAlreadyRegistered;
use AlecRabbit\Spinner\Container\Exception\ContainerNotRegistered;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Throwable;

use function class_exists;

final class AutoInstantiator implements IAutoInstantiator
{
    protected static ?ContainerInterface $container = null;

    public static function registerContainer(ContainerInterface $container): void
    {
        if (null === self::$container) {
            self::$container = $container;
            return;
        }
        throw new ContainerAlreadyRegistered('Container already registered.');
    }

    public static function createInstance(string $class): object
    {
        return match (true) {
            class_exists($class) => self::createInstanceByReflection($class),
            default => throw new RuntimeException('Class does not exist: ' . $class),
        };
    }

    protected static function getContainer(): ContainerInterface
    {
        if (null === self::$container) {
            throw new ContainerNotRegistered('Container not registered.');
        }
        return self::$container;
    }

    protected static function createInstanceByReflection(string $class): object
    {
        $reflection = new ReflectionClass($class);

        $constructorParameters = $reflection->getConstructor()?->getParameters();
        if ($constructorParameters) {
            $parameters = [];
            foreach ($constructorParameters as $parameter) {
                $parameters[$parameter->getName()] =
                    self::getContainer()->get($parameter->getType()?->getName());
            }
            return new $class(...$parameters);
        }

        try {
            return new $class();
        } catch (Throwable $e) {
            throw new RuntimeException('Unable to create instance of ' . $class, previous: $e);
        }
    }
}
