<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Throwable;

use function class_exists;

final class ServiceSpawner implements IServiceSpawner
{
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function spawn(string|callable $definition): object
    {
        // TODO refactor to accept string|callable OR to accept string|callable|object
        //  return match (true) {
        //      is_object($definition) => $definition, // return object as is
        //      is_callable($definition) => $this->spawnByCallable($definition),
        //      is_string($definition) => $this-spawnByConstructor($definition),
        //  };
        return match (true) {
            class_exists($definition) => $this->createInstanceByReflection($definition),
            default => throw new ClassDoesNotExist('Class does not exist: ' . $definition),
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
