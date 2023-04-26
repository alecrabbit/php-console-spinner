<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\NotInContainerException;
use Throwable;
use Traversable;

final class Container implements IContainer
{
    /** @var array<string, callable|object|string> */
    private array $definitions = [];

    /** @var array<string, object> */
    private array $services = [];

    /**
     * Create a container object with a set of definitions.
     *
     * @param null|Traversable<string, callable|object|string> $definitions
     */
    public function __construct(?Traversable $definitions = null)
    {
        if ($definitions) {
            /** @var callable|object|string $definition */
            foreach ($definitions as $id => $definition) {
                $this->addDefinition($id, $definition);
            }
        }
    }

    private function addDefinition(string $id, mixed $definition): void
    {
        if (!is_callable($definition) && !is_object($definition) && !is_string($definition)) {
            throw new ContainerException(
                sprintf(
                    'Definition should be callable, object or string, %s given.',
                    gettype($definition),
                )
            );
        }

        if ($this->has($id)) {
            throw new ContainerException(
                sprintf(
                    'Definition with id "%s" already registered in the container.',
                    $id,
                )
            );
        }

        $this->definitions[$id] = $definition;
    }

    /** @inheritdoc */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->definitions);
    }

    /** @inheritdoc */
    public function replace(string $id, callable|object|string $definition): void
    {
        $serviceRegistered = array_key_exists($id, $this->services);

        $this->remove($id);
        $this->add($id, $definition);
        if ($serviceRegistered) {
            $this->get($id);
        }
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
        if (array_key_exists($id, $this->services)) {
            return $this->services[$id];
        }

        if (!$this->has($id)) {
            throw new NotInContainerException(
                sprintf(
                    'There is not service with id "%s" in the container.',
                    $id,
                )
            );
        }

        $definition = $this->definitions[$id];

        return $this->services[$id] = $this->getService($id, $definition);
    }

    private function getService(string $id, callable|object|string $definition): object
    {
        return match (true) {
            is_callable($definition) => $this->instantiateWithCallable($definition, $id),
            is_object($definition) => $definition,
            is_string($definition) => $this->instantiateByConstructor($definition, $id),
        };
    }

    /** @psalm-suppress MixedInferredReturnType */
    private function instantiateWithCallable(callable $definition, string $id): object
    {
        try {
            /** @psalm-suppress MixedReturnStatement */
            return $definition();
        } catch (Throwable $e) {
            throw new ContainerException(
                sprintf(
                    'Could not instantiate service with callable for "%s".%s',
                    $id,
                    sprintf(
                        ' [%s]: "%s"',
                        get_debug_type($e),
                        $e->getMessage(),
                    ),
                ),
                previous: $e,
            );
        }
    }

    private function instantiateByConstructor(string $class, string $id): object
    {
        if (class_exists($class)) {
            try {
                /** @psalm-suppress MixedMethodCall */
                return new $class();
            } catch (Throwable $e) {
                throw new ContainerException(
                    sprintf(
                        'Could not instantiate service by __construct() for "%s".%s',
                        $id,
                        sprintf(
                            ' [%s]: "%s"',
                            get_debug_type($e),
                            $e->getMessage(),
                        ),
                    ),
                    previous: $e
                );
            }
        }

        throw new ContainerException(
            sprintf(
                'Could not instantiate service for "%s". Class "%s" is not found.',
                $id,
                $class,
            )
        );
    }
}