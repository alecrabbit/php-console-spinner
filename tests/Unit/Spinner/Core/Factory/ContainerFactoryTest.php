<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ContainerFactoryTest extends TestCase
{
    protected static ?IContainer $container = null;

    #[Test]
    public function canBeInstantiated(): void
    {
        $containerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerFactory::class, $containerFactory);
        self::assertNull(self::getPropertyValue('container', ContainerFactory::class));
    }

    public function getTesteeInstance(
        ?IDefinitionRegistry $registry = null
    ): IContainerFactory {
        return
            new ContainerFactory(
                registry: $registry ?? $this->createDefinitionRegistryMock()
            );
    }

    protected function createDefinitionRegistryMock(): MockObject&IDefinitionRegistry
    {
        return $this->createMock(IDefinitionRegistry::class);
    }

    #[Test]
    public function canCreateContainer(): void
    {
        $containerFactory = $this->getTesteeInstance();

        self::assertNull(self::getPropertyValue('container', ContainerFactory::class));

        $container = $containerFactory->getContainer();

        self::assertNotNull(self::getPropertyValue('container', ContainerFactory::class));
        self::assertInstanceOf(Container::class, $container);
    }

    #[Test]
    public function createsSingleton(): void
    {
        $containerFactory = $this->getTesteeInstance();

        $container = $containerFactory->getContainer();

        self::assertSame($container, $containerFactory->getContainer());
        self::assertSame($container, $containerFactory->getContainer());
        self::assertSame($container, $containerFactory->getContainer());
    }

    protected function setUp(): void
    {
        self::$container = self::getPropertyValue('container', ContainerFactory::class);

        self::setPropertyValue(
            ContainerFactory::class,
            'container',
            null
        );
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(
            ContainerFactory::class,
            'container',
            self::$container
        );
    }
}
