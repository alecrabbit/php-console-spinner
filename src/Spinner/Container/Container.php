<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Exception\CircularDependencyException;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\NotInContainerException;
use ArrayObject;
use Closure;
use Throwable;
use Traversable;

final class Container implements IContainer
{
    protected IServiceSpawner $serviceSpawner;

    /** @var ArrayObject<string, callable|object|string> */
    protected ArrayObject $definitions;

    /** @var ArrayObject<string, object> */
    protected ArrayObject $services;

    protected ArrayObject $dependencyStack;

    /**
     * Create a container object with a set of definitions.
     *
     * @param Closure $spawnerCreatorCb
     * @param null|Traversable $definitions
     */
    public function __construct(Closure $spawnerCreatorCb, ?Traversable $definitions = null)
    {
        $this->serviceSpawner = $spawnerCreatorCb($this);
        $this->definitions = new ArrayObject();
        $this->services = new ArrayObject();
        $this->dependencyStack = new ArrayObject();

        if ($definitions) {
            /** @var callable|object|string $definition */
            foreach ($definitions as $id => $definition) {
                $this->addDefinition($id, $definition);
            }
        }
    }

    protected function addDefinition(string $id, mixed $definition): void
    {
        $this->assertDefinition($definition);

        $this->assertNotRegistered($id);

        /** @var callable|object|string $definition */
        $this->definitions[$id] = $definition;
    }

    protected function assertDefinition(mixed $definition): void
    {
        if (!is_callable($definition) && !is_object($definition) && !is_string($definition)) {
            throw new ContainerException(
                sprintf(
                    'Definition should be callable, object or string, %s given.',
                    gettype($definition),
                )
            );
        }
    }

    protected function assertNotRegistered(string $id): void
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

    /** @inheritdoc */
    public function has(string $id): bool
    {
        return $this->definitions->offsetExists($id);
    }

    /** @inheritdoc */
    public function replace(string $id, callable|object|string $definition): void
    {
        $serviceInstantiated = $this->hasService($id);

        $this->remove($id);
        $this->add($id, $definition);
        if ($serviceInstantiated) {
            $this->get($id); // instantiates service with new definition
        }
    }

    protected function hasService(string $id): bool
    {
        return $this->services->offsetExists($id);
    }

    /** @inheritdoc */
    public function remove(string $id): void
    {
        if (!$this->has($id)) {
            throw new NotInContainerException(
                sprintf(
                    'Definition with id "%s" is not registered in the container.',
                    $id,
                )
            );
        }
        unset($this->definitions[$id], $this->services[$id]);
    }

    /** @inheritdoc */
    public function add(string $id, callable|object|string $definition): void
    {
        $this->addDefinition($id, $definition);
    }

    /** @inheritdoc */
    public function get(string $id): object
    {
        if ($this->hasService($id)) {
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

        return $this->services[$id];
    }

    protected function addDependencyToStack(string $id): void
    {
        $this->assertDependencyStack($id);

        $this->dependencyStack->append($id);
    }

    protected function assertDependencyStack(string $id): void
    {
        if (in_array($id, $this->dependencyStack->getArrayCopy(), true)) {
            throw new CircularDependencyException($this->dependencyStack);
        }
    }

    protected function getService(string $id, callable|object|string $definition): object
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

    protected function removeDependencyFromStack(): void
    {
        $this->dependencyStack->offsetUnset($this->dependencyStack->count() - 1);
    }
}
