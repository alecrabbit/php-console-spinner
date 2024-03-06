<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Builder;


use AlecRabbit\Spinner\Container\Builder\ContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerBuilder;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Exception\ContainerException;
use AlecRabbit\Tests\TestCase\TestCase;
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

    private function getTesteeInstance(): IContainerBuilder
    {
        return new ContainerBuilder();
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

        $builder = $this->getTesteeInstance();

        $actual = $builder
            ->withRegistry($registry)
            ->withFactory($factory)
            ->build()
        ;

        self::assertSame($container, $actual);
    }

    private function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    private function getDefinitionRegistryMock(): MockObject&IDefinitionRegistry
    {
        return $this->createMock(IDefinitionRegistry::class);
    }

    private function getContainerFactoryMock(): MockObject&IContainerFactory
    {
        return $this->createMock(IContainerFactory::class);
    }

    #[Test]
    public function throwsIfContainerFactoryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Container factory is not set.');

        $builder->build();
    }

    #[Test]
    public function throwsIfRegistryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Definition registry is not set.');

        $builder
            ->withFactory($this->getContainerFactoryMock())
            ->build()
        ;
    }
}
