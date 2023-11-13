<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;


use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Container\Definition;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DefinitionTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $definition = $this->getTesteeInstance();

        self::assertInstanceOf(Definition::class, $definition);
    }

    private function getTesteeInstance(
        ?string $id = null,
        mixed $definition = null,
        ?int $options = null,
    ): IDefinition {
        return
            new Definition(
                id: $id ?? $this->getFaker()->word(),
                definition: $definition ?? $this->getFaker()->word(),
                options: $options ?? IDefinition::SINGLETON,
            );
    }

    #[Test]
    public function canGetId(): void
    {
        $id = $this->getFaker()->word();

        $definition = $this->getTesteeInstance(id: $id);

        self::assertSame($id, $definition->getId());
    }

    #[Test]
    public function canGetDefinition(): void
    {
        $def = fn() => 1;

        $definition = $this->getTesteeInstance(definition: $def);

        self::assertSame($def, $definition->getDefinition());
    }

    #[Test]
    public function canGetOptions(): void
    {
        $options = IDefinition::TRANSIENT;

        $definition = $this->getTesteeInstance(options: $options);

        self::assertSame($options, $definition->getOptions());
    }

    #[Test]
    public function throwsIfDefinitionIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Definition should be callable, object or string, "int" given.');

        $definition = $this->getTesteeInstance(definition: 1);

        self::assertInstanceOf(Definition::class, $definition);
    }

    #[Test]
    public function throwsIfOptionsValueIsBiggerThenMax(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid options. Max value exceeded: [1].');

        $definition = $this->getTesteeInstance(options: 100);

        self::assertInstanceOf(Definition::class, $definition);
    }

    #[Test]
    public function throwsIfOptionsValueIsBelowZero(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid options. Negative value: [-10].');

        $definition = $this->getTesteeInstance(options: -10);

        self::assertInstanceOf(Definition::class, $definition);
    }
}
