<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Exception\CircularDependencyException;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\NotInContainerException;
use ArrayObject;
use Psr\Container\ContainerExceptionInterface;
use Throwable;
use Traversable;

final class Container implements IContainer
{
    private IServiceSpawner $serviceSpawner;

    /** @var ArrayObject<string, callable|object|class-string> */
    private ArrayObject $definitions;

    /** @var ArrayObject<string, mixed> */
    private ArrayObject $services;

    private ArrayObject $dependencyStack;

    public function __construct(IServiceSpawnerBuilder $spawnerBuilder, ?Traversable $definitions = null)
    {
        $this->serviceSpawner = $spawnerBuilder->withContainer($this)->build();

        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->definitions = new ArrayObject();
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->services = new ArrayObject();
        $this->dependencyStack = new ArrayObject();

        if ($definitions) {
            /**
             * @var string $id
             * @var callable|object|string $definition
             */
            foreach ($definitions as $id => $definition) {
                $this->register($id, $definition);
            }
        }
    }

    private function register(string $id, mixed $definition): void
    {
        $this->assertDefinition($definition);

        $this->assertNotRegistered($id);

        /** @var callable|object|class-string $definition */
        $this->definitions[$id] = $definition;
    }

    private function assertDefinition(mixed $definition): void
    {
        if($definition instanceof IDefinition) {
            throw new ContainerException(
                sprintf(
                    'Unsupported definition, "%s" given.',
                    IDefinition::class,
                )
            );
        }
        if (!is_callable($definition) && !is_object($definition) && !is_string($definition)) {
            throw new ContainerException(
                sprintf(
                    'Definition should be callable, object or string, "%s" given.',
                    gettype($definition),
                )
            );
        }
    }

    private function assertNotRegistered(string $id): void
    {
        if ($this->has($id)) {
            throw new ContainerException(
                sprintf(
                    'Definition with id "%s" already registered in the container.',
                    $id,
                )
            );
        }
    }

    public function has(string $id): bool
    {
        return $this->definitions->offsetExists($id);
    }

    /**
     * @inheritDoc
     * @psalm-suppress MixedInferredReturnType
     */
    public function get(string $id): mixed
    {
        if ($this->hasService($id)) {
            /** @psalm-suppress MixedReturnStatement */
            return $this->services[$id];
        }

        if (!$this->has($id)) {
            throw new NotInContainerException(
                sprintf(
                    'There is no service with id "%s" in the container.',
                    $id,
                )
            );
        }

        $this->addDependencyToStack($id);

        $definition = $this->definitions[$id];

        $this->services[$id] = $this->getService($id, $definition);

        $this->removeDependencyFromStack();

        /** @psalm-suppress MixedReturnStatement */
        return $this->services[$id];
    }

    private function hasService(string $id): bool
    {
        return $this->services->offsetExists($id);
    }

    private function addDependencyToStack(string $id): void
    {
        $this->assertDependencyIsNotInStack($id);

        $this->dependencyStack->append($id);
    }

    private function assertDependencyIsNotInStack(string $id): void
    {
        if (in_array($id, $this->dependencyStack->getArrayCopy(), true)) {
            // @codeCoverageIgnoreStart
            throw new CircularDependencyException($this->dependencyStack);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @param class-string|object|callable $definition
     *
     * @throws ContainerExceptionInterface
     */
    private function getService(string $id, callable|object|string $definition): object
    {
        try {
            return $this->serviceSpawner->spawn($definition);
        } catch (Throwable $e) {
            throw new ContainerException(
                sprintf(
                    'Could not instantiate service with id "%s".%s',
                    $id,
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

    private function removeDependencyFromStack(): void
    {
        $this->dependencyStack->offsetUnset($this->dependencyStack->count() - 1);
    }
}
