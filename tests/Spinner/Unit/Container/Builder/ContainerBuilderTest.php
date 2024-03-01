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
        ?IContainerFactoryStore $factories = null
    ): IContainerBuilder {
        return new ContainerBuilder(
            registry: $registry ?? $this->getDefinitionRegistryMock(),
            factories: $factories ?? $this->getContainerFactoryStoreMock()
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

    #[Test]
    public function canBuild(): void
    {
        $container = $this->getContainerMock();
        $registry = $this->getDefinitionRegistryMock();
        $factories = $this->getContainerFactoryStoreMock();
        $factory01 = $this->getContainerFactoryMock();
        $factory01
            ->expects($this->once())
            ->method('isSupported')
            ->willReturn(false)
        ;
        $factory02 = $this->getContainerFactoryMock();
        $factory02
            ->expects($this->once())
            ->method('isSupported')
            ->willReturn(true)
        ;
        $factory02
            ->expects($this->once())
            ->method('create')
            ->with($registry)
            ->willReturn($container)
        ;

        $factories
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(
                new ArrayIterator([
                    $factory01,
                    $factory02,
                ])
            )
        ;

        $builder = $this->getTesteeInstance(
            registry: $registry,
            factories: $factories,
        );

        self::assertSame($container, $builder->build());
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
    public function throwsIfNoSupportedFactoryFound(): void
    {
        $registry = $this->getDefinitionRegistryMock();
        $factories = $this->getContainerFactoryStoreMock();
        $factory01 = $this->getContainerFactoryMock();
        $factory01
            ->expects($this->once())
            ->method('isSupported')
            ->willReturn(false)
        ;
        $factory02 = $this->getContainerFactoryMock();
        $factory02
            ->expects($this->once())
            ->method('isSupported')
            ->willReturn(false)
        ;

        $factories
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(
                new ArrayIterator([
                    $factory01,
                    $factory02,
                ])
            )
        ;

        $builder = $this->getTesteeInstance(
            registry: $registry,
            factories: $factories,
        );

        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('No supported container factory found.');

        $builder->build();
    }
}
