<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawner;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Spinner\Container\Exception\NotFoundInContainer;
use ArrayObject;
use Psr\Container\ContainerExceptionInterface;
use Throwable;
use Traversable;

final readonly class Container implements IContainer
{
    private IServiceSpawner $serviceSpawner;

    /** @var ArrayObject<string, IServiceDefinition> */
    private ArrayObject $definitions;

    /** @var ArrayObject<string, IService> */
    private ArrayObject $services;

    /**
     * @param Traversable<string|int, IServiceDefinition>|null $definitions
     */
    public function __construct(
        IServiceSpawnerFactory $spawnerFactory,
        ?Traversable $definitions = null,
    ) {
        $this->serviceSpawner = $spawnerFactory->create($this);

        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->definitions = new ArrayObject();
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $this->services = new ArrayObject();

        if ($definitions) {
            /**
             * @var int|string $id
             * @var IServiceDefinition $definition
             */
            foreach ($definitions as $id => $definition) {
                $this->register($id, $definition);
            }
        }
    }

    private function register(int|string $id, IServiceDefinition $definition): void
    {
        if (is_int($id)) {
            $id = $definition->getId();
        }

        $this->registerDefinition($id, $definition);
    }

    private function registerDefinition(string $id, IServiceDefinition $definition): void
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
     *
     * @psalm-suppress MixedInferredReturnType
     */
    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new NotFoundInContainer(
                sprintf(
                    'There is no service with id "%s" in the container.',
                    $id,
                )
            );
        }

        if ($this->hasService($id)) {
            /** @psalm-suppress MixedReturnStatement */
            return $this->retrieveService($id)->getValue();
        }

        /** @psalm-suppress MixedReturnStatement */
        return $this->getService($id)->getValue();
    }

    private function hasService(string $id): bool
    {
        return $this->services->offsetExists($id);
    }

    private function retrieveService(string $id): IService
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->services->offsetGet($id);
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function getService(string $id): IService
    {
        $definition = $this->getDefinition($id);

        $service = $this->spawn($definition);

        if ($service->isStorable()) {
            $this->services->offsetSet($id, $service);
        }

        /** @psalm-suppress MixedReturnStatement */
        return $service;
    }

    private function getDefinition(string $id): IServiceDefinition
    {
        return $this->definitions->offsetGet($id);
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function spawn(IServiceDefinition $definition): IService
    {
        try {
            return $this->serviceSpawner->spawn($definition);
        } catch (Throwable $e) {
            $details =
                sprintf(
                    '[%s]: "%s".',
                    get_debug_type($e),
                    $e->getMessage(),
                );

            throw new ContainerException(
                sprintf(
                    'Could not instantiate service. %s',
                    $details,
                ),
                previous: $e,
            );
        }
    }
}
