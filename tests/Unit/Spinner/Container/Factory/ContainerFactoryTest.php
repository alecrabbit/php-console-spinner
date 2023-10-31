<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
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

        $container = $containerFactory->create();

        self::assertInstanceOf(Container::class, $container);
    }
}
