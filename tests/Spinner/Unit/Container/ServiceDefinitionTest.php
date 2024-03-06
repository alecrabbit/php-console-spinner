<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;


use AlecRabbit\Spinner\Container\Contract\IReference;
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
        IReference|string $definition = null,
        ?int $options = null,
    ): IServiceDefinition {
        return
            new ServiceDefinition(
                id: $id ?? self::getFaker()->word(),
                definition: $definition ?? stdClass::class,
                options: $options ?? IServiceDefinition::SINGLETON,
            );
    }

    #[Test]
    public function canGetId(): void
    {
        $id = self::getFaker()->word();

        $serviceDefinition = $this->getTesteeInstance(id: $id);

        self::assertSame($id, $serviceDefinition->getId());
    }

    #[Test]
    public function canGetDefinition(): void
    {
        $def = stdClass::class;

        $serviceDefinition = $this->getTesteeInstance(definition: $def);

        self::assertSame($def, $serviceDefinition->getDefinition());
    }

    #[Test]
    public function canCheckIsSingleton(): void
    {
        $options = IServiceDefinition::SINGLETON | IServiceDefinition::PUBLIC;

        $serviceDefinition = $this->getTesteeInstance(options: $options);

        self::assertTrue($serviceDefinition->isSingleton());
    }

    #[Test]
    public function canCheckIsPublic(): void
    {
        $options = IServiceDefinition::SINGLETON | IServiceDefinition::PUBLIC;

        $serviceDefinition = $this->getTesteeInstance(options: $options);

        self::assertTrue($serviceDefinition->isPublic());
    }

    #[Test]
    public function throwsIfOptionsValueIsBiggerThenMax(): void
    {
        $max = IServiceDefinition::SINGLETON
            | IServiceDefinition::PUBLIC;

        $this->expectException(InvalidOptionsArgument::class);
        $this->expectExceptionMessage(sprintf('Invalid options. Max value exceeded: [%s].', $max));

        $serviceDefinition = $this->getTesteeInstance(options: $max << 1);

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
