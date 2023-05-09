<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Core\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IContainerFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ContainerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $containerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ContainerFactory::class, $containerFactory);
        self::assertNull(self::getPropertyValue('container', ContainerFactory::class));
    }

    public function getTesteeInstance(
        ?IDefinitionRegistry $registry = null
    ): IContainerFactory {
        return new ContainerFactory(
            registry: $registry ?? $this->createDefinitionRegistryMock()
        );
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
        self::setPropertyValue(
            ContainerFactory::class,
            'container',
            null
        );
    }
}
