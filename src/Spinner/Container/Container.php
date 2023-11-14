<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Exception\CircularDependencyDetected;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\NotFoundInContainer;
use ArrayObject;
use Psr\Container\ContainerExceptionInterface;
use Throwable;
use Traversable;

final readonly class Container implements IContainer
{
    private IServiceSpawner $serviceSpawner;

    /** @var ArrayObject<string, IDefinition> */
    private ArrayObject $definitions;

    /** @var ArrayObject<string, mixed> */
    private ArrayObject $services;

    /** @var ArrayObject<int, string> */
    private ArrayObject $dependencyStack;

    public function __construct(
        IServiceSpawnerBuilder $spawnerBuilder,
        ?Traversable $definitions = null,
    ) {
        $this->serviceSpawner = $spawnerBuilder->withContainer($this)->build();

        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->definitions = new ArrayObject();
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->services = new ArrayObject();
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->dependencyStack = new ArrayObject();

        if ($definitions) {
            /**
             * @var string $id
             * @var IDefinition $definition
             */
            foreach ($definitions as $id => $definition) {
                $this->register($id, $definition);
            }
        }
    }

    protected function register(string $id, IDefinition $definition): void
    {
        $this->assertNotRegistered($id);

        $this->definitions->offsetSet($id, $definition);
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
        return $this->hasDefinition($id);
    }

    private function hasDefinition(string $id): bool
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
            return $this->retrieveService($id);
        }

        if (!$this->has($id)) {
            throw new NotFoundInContainer(
                sprintf(
                    'There is no service with id "%s" in the container.',
                    $id,
                )
            );
        }

        /** @psalm-suppress MixedReturnStatement */
        return $this->getService($id);
    }

    private function hasService(string $id): bool
    {
        return $this->services->offsetExists($id);
    }

    private function retrieveService(string $id): mixed
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->services->offsetGet($id);
    }

    private function getService(string $id): mixed
    {
        /** @var IDefinition $definition */
        $definition = $this->definitions->offsetGet($id);

        $service = $this->spawnService($definition);

        if ($definition->isSingleton()) {
            $this->services->offsetSet($id, $service);
        }

        /** @psalm-suppress MixedReturnStatement */
        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function spawnService(IDefinition $definition): object
    {
        $id = $definition->getId();

        try {
            $this->addDependencyToStack($id);

            $service = $this->serviceSpawner->spawn($definition->getDefinition());

            $this->removeDependencyFromStack($id);

            return $service;
        } catch (Throwable $e) {
            $detailsMessage =
                sprintf(
                    '[%s]: "%s".',
                    get_debug_type($e),
                    $e->getMessage(),
                );

            throw new ContainerException(
                sprintf(
                    'Could not instantiate service with id "%s". %s',
                    $id,
                    $detailsMessage,
                ),
                previous: $e,
            );
        }
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
            throw new CircularDependencyDetected($this->dependencyStack);
            // @codeCoverageIgnoreEnd
        }
    }

    private function removeDependencyFromStack(string $id): void
    {
        foreach ($this->dependencyStack as $key => $item) {
            if ($item === $id) {
                $this->dependencyStack->offsetUnset($key);
                break;
            }
        }
    }
}
