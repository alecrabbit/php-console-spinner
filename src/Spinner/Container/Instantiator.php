<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IInstantiator;
use AlecRabbit\Spinner\Container\Exception\ContainerAlreadyRegistered;
use AlecRabbit\Spinner\Container\Exception\ContainerNotRegistered;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Throwable;

use function class_exists;

final class Instantiator implements IInstantiator
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
            default => throw new ClassDoesNotExist('Class does not exist: ' . $class),
        };
    }

    protected static function createInstanceByReflection(string $class): object
    {
        $reflection = new ReflectionClass($class);

        $constructorParameters = $reflection->getConstructor()?->getParameters();
        if ($constructorParameters) {
            $parameters = [];
            foreach ($constructorParameters as $parameter) {
                $name = $parameter->getName();
                $id = $parameter->getType()?->getName();
                if (null === $id) {
                    throw new UnableToExtractType('Unable to extract type for parameter name: $' . $name);
                }
                $parameters[$name] = self::getContainer()->get($id);
            }
            return new $class(...$parameters);
        }

        try {
            return new $class();
        } catch (Throwable $e) {
            throw new UnableToCreateInstance('Unable to create instance of ' . $class, previous: $e);
        }
    }

    protected static function getContainer(): ContainerInterface
    {
        if (null === self::$container) {
            throw new ContainerNotRegistered('Container not registered.');
        }
        return self::$container;
    }
}
