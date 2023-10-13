<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

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

        $typeId = 'test';
        $definition = 'test';
        $registry->bind($typeId, $definition);
        self::assertCount(1, iterator_to_array($registry->load()));
        $definitions = self::getPropertyValue('definitions', $registry);
        self::assertSame($definition, $definitions[$typeId]);
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
