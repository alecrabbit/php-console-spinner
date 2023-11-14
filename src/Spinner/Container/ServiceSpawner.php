<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\ClassDoesNotExist;
use AlecRabbit\Spinner\Container\Exception\SpawnFailed;
use AlecRabbit\Spinner\Container\Exception\UnableToCreateInstance;
use AlecRabbit\Spinner\Container\Exception\UnableToExtractType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use Throwable;

final readonly class ServiceSpawner implements IServiceSpawner
{
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

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
            throw new SpawnFailed(
                sprintf(
                    'Could not spawn service.%s',
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

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    private function spawnByCallable(callable $definition): object
    {
        return $definition($this->container);
    }

    /**
     * @param class-string $definition
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    private function spawnByClassConstructor(string $definition): object
    {
        return
            match (true) {
                class_exists($definition) => $this->createInstanceByReflection($definition),
                default => throw new ClassDoesNotExist(
                    sprintf('Class does not exist: %s', (string)$definition)
                ),
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
                if ($type === null) {
                    throw new UnableToExtractType('Unable to extract type for parameter name: $' . $name);
                }
                if ($this->needsService($type)) {
                    /** @var ReflectionNamedType $type */
                    $parameters[$name] = $this->getServiceFromContainer($type->getName());
                }
            }
            /** @psalm-suppress MixedMethodCall */
            return new $class(...$parameters);
        }

        try {
            /** @psalm-suppress MixedMethodCall */
            return new $class();
        } catch (Throwable $e) {
            throw new UnableToCreateInstance('Unable to create instance of ' . $class, previous: $e);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function needsService(mixed $type): bool
    {
        return
            match (true) {
                // assumes that all non-builtin types are services
                $type instanceof ReflectionNamedType => !$type->isBuiltin(),
                default => throw new UnableToExtractType(
                    sprintf(
                        'Only %s is supported.',
                        ReflectionNamedType::class,
                    )
                ),
            };
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getServiceFromContainer(string $id): object
    {
        return $this->container->get($id);
    }
}
