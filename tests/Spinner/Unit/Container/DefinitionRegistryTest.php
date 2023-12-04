<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DefinitionRegistryTest extends TestCase
{
    private ?IDefinitionRegistry $registry = null;

    #[Test]
    public function canBeInstantiated(): void
    {
        $registry = $this->getTesteeInstance();

        self::assertInstanceOf(DefinitionRegistry::class, $registry);
    }

    protected function getTesteeInstance(): IDefinitionRegistry
    {
        return DefinitionRegistry::getInstance();
    }

    #[Test]
    public function isCreatedEmpty(): void
    {
        $registry = $this->getTesteeInstance();

        self::assertInstanceOf(DefinitionRegistry::class, $registry);
        self::assertCount(0, iterator_to_array($registry->load()));
    }

    #[Test]
    public function definitionCanBeBound(): void
    {
        $registry = $this->getTesteeInstance();

        $serviceDefinition1 = $this->getServiceDefinitionMock();
        $serviceDefinition1
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service1')
        ;
        $serviceDefinition2 = $this->getServiceDefinitionMock();
        $serviceDefinition2
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service2')
        ;
        $serviceDefinition3 = $this->getServiceDefinitionMock();
        $serviceDefinition3
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service3')
        ;

        $registry->bind($serviceDefinition1);
        $registry->bind($serviceDefinition2);
        $registry->bind($serviceDefinition3);

        $definitions = iterator_to_array($registry->load());

        self::assertCount(3, $definitions);

        self::assertSame($serviceDefinition1, $definitions['service1']);
        self::assertSame($serviceDefinition2, $definitions['service2']);
        self::assertSame($serviceDefinition3, $definitions['service3']);
    }

    private function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }

    #[Test]
    public function definitionCanBeBoundAsMultipleParams(): void
    {
        $registry = $this->getTesteeInstance();

        $serviceDefinition1 = $this->getServiceDefinitionMock();
        $serviceDefinition1
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service1')
        ;
        $serviceDefinition2 = $this->getServiceDefinitionMock();
        $serviceDefinition2
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service2')
        ;
        $serviceDefinition3 = $this->getServiceDefinitionMock();
        $serviceDefinition3
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service3')
        ;

        $registry->bind(
            $serviceDefinition1,
            $serviceDefinition2,
            $serviceDefinition3
        );

        $definitions = iterator_to_array($registry->load());

        self::assertCount(3, $definitions);

        self::assertSame($serviceDefinition1, $definitions['service1']);
        self::assertSame($serviceDefinition2, $definitions['service2']);
        self::assertSame($serviceDefinition3, $definitions['service3']);
    }

    #[Test]
    public function definitionCanBeOverridden(): void
    {
        $registry = $this->getTesteeInstance();

        $serviceDefinition1 = $this->getServiceDefinitionMock();
        $serviceDefinition1
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service1')
        ;
        $serviceDefinition2 = $this->getServiceDefinitionMock();
        $serviceDefinition2
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service2')
        ;
        $serviceDefinition3 = $this->getServiceDefinitionMock();
        $serviceDefinition3
            ->expects(self::once())
            ->method('getId')
            ->willReturn('service2')
        ;

        $registry->bind($serviceDefinition1);
        $registry->bind($serviceDefinition2);
        $registry->bind($serviceDefinition3);

        $definitions = iterator_to_array($registry->load());

        self::assertCount(2, $definitions);

        self::assertSame($serviceDefinition1, $definitions['service1']);
        self::assertSame($serviceDefinition3, $definitions['service2']);
        self::assertNotSame($serviceDefinition2, $definitions['service2']);
    }

    #[Test]
    public function isSingleton(): void
    {
        $registry = $this->getTesteeInstance();

        self::assertInstanceOf(DefinitionRegistry::class, $registry);

        self::assertSame($registry, $this->getTesteeInstance());
        self::assertSame($registry, $this->getTesteeInstance());
    }

    protected function setUp(): void
    {
        $this->registry = self::getPropertyValue('instance', DefinitionRegistry::class);
        self::setPropertyValue(DefinitionRegistry::class, 'instance', null);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(DefinitionRegistry::class, 'instance', $this->registry);
    }
}
