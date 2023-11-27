<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceSpawnerFactory;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ContainerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $containerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerFactory::class, $containerFactory);
    }

    public function getTesteeInstance(
        ?IDefinitionRegistry $registry = null,
        ?IServiceSpawnerFactory $spawnerFactory = null
    ): IContainerFactory {
        return
            new ContainerFactory(
                definitionRegistry: $registry ?? $this->getDefinitionRegistryMock(),
                spawnerFactory: $spawnerFactory ?? $this->getSpawnerFactoryMock(),
            );
    }

    protected function getDefinitionRegistryMock(): MockObject&IDefinitionRegistry
    {
        return $this->createMock(IDefinitionRegistry::class);
    }

    private function getSpawnerFactoryMock(): MockObject&IServiceSpawnerFactory
    {
        return $this->createMock(IServiceSpawnerFactory::class);
    }

    #[Test]
    public function canCreateContainer(): void
    {
        $containerFactory = $this->getTesteeInstance();

        $container = $containerFactory->create();

        self::assertInstanceOf(Container::class, $container);
    }

    protected function getSpawnerBuilderMock(): MockObject&IServiceSpawnerBuilder
    {
        return $this->createMock(IServiceSpawnerBuilder::class);
    }
}
