<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IInstanceSpawner;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Throwable;

use function class_exists;

final class InstanceSpawner implements IInstanceSpawner
{
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function spawn(string $class): object
    {
        return match (true) {
            class_exists($class) => $this->createInstanceByReflection($class),
            default => throw new ClassDoesNotExist('Class does not exist: ' . $class),
        };
    }

    protected function createInstanceByReflection(string $class): object
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
                $parameters[$name] = $this->container->get($id);
            }
            return new $class(...$parameters);
        }

        try {
            return new $class();
        } catch (Throwable $e) {
            throw new UnableToCreateInstance('Unable to create instance of ' . $class, previous: $e);
        }
    }
}
