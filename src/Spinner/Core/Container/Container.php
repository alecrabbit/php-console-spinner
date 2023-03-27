<?php

declare(strict_types=1);
// 27.03.23
namespace AlecRabbit\Spinner\Core\Container;

use AlecRabbit\Spinner\Core\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Core\Container\Exception\NotInContainerException;
use Throwable;

final class Container implements IContainer
{
    /** @var array<string, callable|object|string> */
    private array $definitions = [];

    /** @var array<string, object> */
    private array $services = [];

    /**
     * Create a container object with a set of definitions. The array value MUST
     * produce an object that implements Extension.
     *
     * @param array<string, callable|object|string> $definitions
     */
    public function __construct(array $definitions)
    {
        /** @var callable|object|string $definition */
        foreach ($definitions as $id => $definition) {
            $this->addDefinition($id, $definition);
        }
    }

    private function addDefinition(string $id, mixed $definition): void
    {
        self::assertDefinition($definition);
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->definitions[$id] = $definition;
    }

    private static function assertDefinition(mixed $definition): void
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

    /**
     * Retrieve a service from the container.
     *
     * @param string $id
     *
     * @return object
     * @throws NotInContainerException
     */
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

    /**
     * Check if the container contains a given identifier.
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->definitions);
    }

    public function add(string $id, mixed $definition): void
    {
        $this->addDefinition($id, $definition);
    }

    /**
     * Get the service from a definition.
     *
     * @param string $id
     * @param callable|object|string $definition
     * @return object
     */
    private function getService(string $id, callable|object|string $definition): object
    {
        return match (true) {
            is_callable($definition) => $this->instantiateServiceWithCallable($definition, $id),
            is_object($definition) => $definition,
            is_string($definition) => $this->instantiateServiceByClass($definition, $id),
        };
    }

    /** @psalm-suppress MixedInferredReturnType */
    private function instantiateServiceWithCallable(callable $definition, string $id): object
    {
        try {
            /** @psalm-suppress MixedReturnStatement */
            return $definition();
        } catch (Throwable $e) {
            throw new ContainerException(
                sprintf('Error while invoking callable for "%s"', $id),
                previous: $e,
            );
        }
    }

    private function instantiateServiceByClass(string $class, string $id): object
    {
        if (class_exists($class)) {
            try {
                /** @psalm-suppress MixedMethodCall */
                return new $class();
            } catch (Throwable $e) {
                throw new ContainerException(
                    sprintf('Could not instantiate class "%s"', $id),
                    previous: $e
                );
            }
        }

        throw new ContainerException(
            sprintf(
                'Could not instantiate class "%s". Class was not found.',
                $id,
            )
        );
    }
}