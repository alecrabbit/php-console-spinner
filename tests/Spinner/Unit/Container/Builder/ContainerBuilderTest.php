<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Builder;


use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IContainerFactoryStore;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayIterator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ContainerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerBuilder::class, $builder);
    }

    private function getTesteeInstance(
        ?IDefinitionRegistry $registry = null,
    ): IContainerBuilder {
        return new ContainerBuilder(
            registry: $registry ?? $this->getDefinitionRegistryMock(),
        );
    }

    private function getDefinitionRegistryMock(): MockObject&IDefinitionRegistry
    {
        return $this->createMock(IDefinitionRegistry::class);
    }

    private function getContainerFactoryStoreMock(): MockObject&IContainerFactoryStore
    {
        return $this->createMock(IContainerFactoryStore::class);
    }

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    private function getContainerFactoryMock(): MockObject&IContainerFactory
    {
        return $this->createMock(IContainerFactory::class);
    }

    #[Test]
    public function canBuild(): void
    {
        $container = $this->getContainerMock();
        $registry = $this->getDefinitionRegistryMock();

        $factory = $this->getContainerFactoryMock();
        $factory
            ->expects($this->once())
            ->method('create')
            ->with($registry)
            ->willReturn($container)
        ;

        $builder = $this->getTesteeInstance(
            registry: $registry,
        );

        $actual = $builder
            ->withFactory($factory)
            ->build()
        ;

        self::assertSame($container, $actual);
    }

    #[Test]
    public function throwsIfContainerFactoryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Container factory is not set.');

        $builder->build();
    }
}
