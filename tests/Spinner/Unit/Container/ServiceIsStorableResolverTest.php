<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\IIsStorableResolver;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\ServiceIsStorableResolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ServiceIsStorableResolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $service = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceIsStorableResolver::class, $service);
    }

    protected function getTesteeInstance(): IIsStorableResolver
    {
        return
            new ServiceIsStorableResolver();
    }

    #[Test]
    public function canDefineIsStorable(): void
    {
        $solver = $this->getTesteeInstance();

        $definition = $this->getServiceDefinitionMock();
        $definition
            ->expects(self::once())
            ->method('isSingleton')
            ->willReturn(true)
        ;

        self::assertTrue($solver->isStorable($definition));
    }

    private function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }

    #[Test]
    public function canDefineIsNotStorable(): void
    {
        $solver = $this->getTesteeInstance();

        $definition = $this->getServiceDefinitionMock();
        $definition
            ->expects(self::once())
            ->method('isSingleton')
            ->willReturn(false)
        ;

        self::assertFalse($solver->isStorable($definition));
    }
}
