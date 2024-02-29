<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceFactory;
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
use ReflectionType;
use Throwable;

final readonly class ServiceSpawner implements IServiceSpawner
{
    public function __construct(
        private ContainerInterface $container,
        private ICircularDependencyDetector $circularDependencyDetector,
        private IServiceFactory $serviceObjectFactory,
    ) {
    }

    public function spawn(IServiceDefinition $serviceDefinition): IService
    {
        try {
            return $this->spawnService($serviceDefinition);
        } catch (Throwable $e) {
            $details =
                sprintf(
                    '[%s]: "%s".',
                    get_debug_type($e),
                    $e->getMessage(),
                );

            throw new SpawnFailed(
                sprintf(
                    'Failed to spawn service with id "%s". %s',
                    $serviceDefinition->getId(),
                    $details,
                ),
                previous: $e,
            );
        }
    }

    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function spawnService(IServiceDefinition $serviceDefinition): IService
    {
        $this->circularDependencyDetector->push($serviceDefinition->getId());

        $definition = $serviceDefinition->getDefinition();

        $value =
            match (true) {
                is_callable($definition) => $this->spawnByCallable($definition),
                is_string($definition) => $this->spawnByClassConstructor($definition),
                default => $this->refine($definition), // return object as is
            };

        $this->circularDependencyDetector->pop();

        return $this->serviceObjectFactory->create(
            value: $value,
            serviceDefinition: $serviceDefinition,
        );
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    private function spawnByCallable(callable $definition): object
    {
        @trigger_error(
            'Using callable as service definition is deprecated. Use class-string or Reference to invokable instead.',
            \E_USER_DEPRECATED
        );

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
        return match (true) {
            class_exists($definition) => $this->createInstanceByReflection($definition),
            default => throw new ClassDoesNotExist(
                sprintf('Class does not exist: %s', $definition)
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
                if ($parameter->isDefaultValueAvailable()) {
                    /** @psalm-suppress MixedAssignment */
                    $parameters[$name] = $parameter->getDefaultValue();
                    continue;
                }

                /** @var ReflectionType|null $type */
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
        return match (true) {
            // assumes that all non-builtin types are services
            $type instanceof ReflectionNamedType => !$type->isBuiltin(),
            default => throw new UnableToExtractType(
                sprintf(
                    'Only "%s" parameters are supported without default value. "%s" given.',
                    ReflectionNamedType::class,
                    get_debug_type($type)
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

    private function refine(object $object): object
    {
        if ($object instanceof IReference) {
            return $this->spawnFromReference($object);
        }

        return $object;
    }

    protected function spawnFromReference(IReference $object)
    {
        $id = $object->__toString();
        $invokable = $this->getServiceFromContainer($id);

        if (\is_callable($invokable)) {
            return $invokable();
        }

        throw new SpawnFailed(
            sprintf(
                'Service with id "%s" is not invokable.',
                $id,
            )
        );
    }
}
