<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\SpawnFailedException;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionUnionType;
use Throwable;

final class ServiceSpawner implements IServiceSpawner
{
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    /** @inheritdoc */
    public function spawn(string|callable|object $definition): object
    {
        try {
            return
                match (true) {
                    is_callable($definition) => $this->spawnByCallable($definition),
                    is_string($definition) => $this->spawnByClassConstructor($definition),
                    default => $definition, // return object as is
                };
        } catch (Throwable $e) {
            throw new SpawnFailedException(
                sprintf(
                    'Could not spawn object with callable.%s',
                    sprintf(
                        ' [%s]: "%s".',
                        get_debug_type($e),
                        $e->getMessage(),
                    ),
                ),
                previous: $e,
            );
        }
    }

    protected function spawnByCallable(callable $definition): object
    {
        /** @psalm-suppress MixedReturnStatement */
        return $definition($this->container);
    }

    /**
     * @param class-string $definition
     * @return object
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    protected function spawnByClassConstructor(string $definition): object
    {
        return
            match (true) {
                class_exists($definition) => $this->createInstanceByReflection($definition),
                default => throw new ClassDoesNotExist('Class does not exist: ' . $definition),
            };
    }

    /**
     * @param class-string $class
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    private function createInstanceByReflection(string $class): object
    {
        $reflection = new ReflectionClass($class);

        $constructorParameters = $reflection->getConstructor()?->getParameters();
        if ($constructorParameters) {
            $parameters = [];
            foreach ($constructorParameters as $parameter) {
                $name = $parameter->getName();
                $type = $parameter->getType();
                if (null === $type) {
                    throw new UnableToExtractType('Unable to extract type for parameter name: $' . $name);
                }
                if ($this->needsService($type)) {
                    $parameters[$name] = $this->getServiceFromContainer($type->getName());
                }
            }
            return new $class(...$parameters);
        }

        try {
            return new $class();
        } catch (Throwable $e) {
            throw new UnableToCreateInstance('Unable to create instance of ' . $class, previous: $e);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function needsService(ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType $type): bool
    {
        return
            match (true) {
                $type instanceof ReflectionNamedType => !$type->isBuiltin(
                ), // assumes that all non-builtin types are services
                default => throw new UnableToExtractType(
                    sprintf(
                        'Only %s is supported.',
                        ReflectionNamedType::class,
                    )
                ),
            };
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getServiceFromContainer(string $id): object
    {
        return $this->container->get($id);
    }
}
