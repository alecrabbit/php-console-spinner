<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;


use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Exception\InvalidDefinitionArgument;
use AlecRabbit\Spinner\Container\Exception\InvalidOptionsArgument;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ServiceDefinitionTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $serviceDefinition = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceDefinition::class, $serviceDefinition);
    }

    private function getTesteeInstance(
        ?string $id = null,
        mixed $definition = null,
        ?int $options = null,
    ): IServiceDefinition {
        return
            new ServiceDefinition(
                id: $id ?? $this->getFaker()->word(),
                definition: $definition ?? stdClass::class,
                options: $options ?? IServiceDefinition::SINGLETON,
            );
    }

    #[Test]
    public function canGetId(): void
    {
        $id = $this->getFaker()->word();

        $serviceDefinition = $this->getTesteeInstance(id: $id);

        self::assertSame($id, $serviceDefinition->getId());
    }

    #[Test]
    public function canGetDefinition(): void
    {
        $def = fn() => 1;

        $serviceDefinition = $this->getTesteeInstance(definition: $def);

        self::assertSame($def, $serviceDefinition->getDefinition());
    }

    #[Test]
    public function canGetOptions(): void
    {
        $options = IServiceDefinition::TRANSIENT;

        $serviceDefinition = $this->getTesteeInstance(options: $options);

        self::assertSame($options, $serviceDefinition->getOptions());
    }

    #[Test]
    public function throwsIfDefinitionIsInvalid(): void
    {
        $this->expectException(InvalidDefinitionArgument::class);
        $this->expectExceptionMessage('Definition should be callable, object or string, "int" given.');

        $serviceDefinition = $this->getTesteeInstance(definition: 1);

        self::assertInstanceOf(ServiceDefinition::class, $serviceDefinition);
    }

    #[Test]
    public function throwsIfOptionsValueIsBiggerThenMax(): void
    {
        $this->expectException(InvalidOptionsArgument::class);
        $this->expectExceptionMessage('Invalid options. Max value exceeded: [1].');

        $serviceDefinition = $this->getTesteeInstance(options: 100);

        self::assertInstanceOf(ServiceDefinition::class, $serviceDefinition);
    }

    #[Test]
    public function throwsIfOptionsValueIsBelowZero(): void
    {
        $this->expectException(InvalidOptionsArgument::class);
        $this->expectExceptionMessage('Invalid options. Negative value: [-10].');

        $serviceDefinition = $this->getTesteeInstance(options: -10);

        self::assertInstanceOf(ServiceDefinition::class, $serviceDefinition);
    }
}
