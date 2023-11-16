<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Service;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ServiceTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $service = $this->getTesteeInstance();

        self::assertInstanceOf(Service::class, $service);
    }

    protected function getTesteeInstance(
        mixed $value = null,
        ?IServiceDefinition $serviceDefinition = null,
        ?bool $storable = null,
    ): IService {
        return
            new Service(
                value: $value,
                serviceDefinition: $serviceDefinition ?? $this->getServiceDefinitionMock(),
                storable: $storable ?? false,
            );
    }

    private function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }

    #[Test]
    public function canGetValue(): void
    {
        $value = new stdClass();

        $service = $this->getTesteeInstance(
            value: $value,
        );

        self::assertSame($value, $service->getValue());
    }

    #[Test]
    public function canGetServiceDefinition(): void
    {
        $serviceDefinition = $this->getServiceDefinitionMock();

        $service = $this->getTesteeInstance(
            serviceDefinition: $serviceDefinition,
        );

        self::assertSame($serviceDefinition, $service->getServiceDefinition());
    }

    #[Test]
    public function canGetStorable(): void
    {
        $service = $this->getTesteeInstance(
            storable: true,
        );

        self::assertTrue($service->isStorable());
    }
}
