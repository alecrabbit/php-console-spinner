<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Factory;

use AlecRabbit\Spinner\Container\Contract\IIsStorableResolver;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceFactory;
use AlecRabbit\Spinner\Container\Factory\ServiceFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ServiceObjectFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IIsStorableResolver $isStorableSolver = null,
        ?IServiceBuilder $serviceBuilder = null,
    ): IServiceFactory {
        return
            new ServiceFactory(
                isStorableResolver: $isStorableSolver ?? $this->getIsStorableSolverMock(),
                serviceBuilder: $serviceBuilder ?? $this->getServiceBuilderMock(),
            );
    }

    private function getIsStorableSolverMock(): MockObject&IIsStorableResolver
    {
        return $this->createMock(IIsStorableResolver::class);
    }

    private function getServiceBuilderMock(): MockObject&IServiceBuilder
    {
        return $this->createMock(IServiceBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $isStorable = true;
        $solver = $this->getIsStorableSolverMock();
        $solver
            ->expects(self::once())
            ->method('isStorable')
            ->willReturn($isStorable)
        ;
        $builder = $this->getServiceBuilderMock();

        $factory = $this->getTesteeInstance(
            isStorableSolver: $solver,
            serviceBuilder: $builder,
        );

        $id = self::getFaker()->word();
        $value = new stdClass();
        $serviceDefinition = $this->getServiceDefinitionMock();
        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn($id)
        ;

        $builder
            ->expects(self::once())
            ->method('withValue')
            ->with($value)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withId')
            ->with($id)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withIsStorable')
            ->with($isStorable)
            ->willReturnSelf()
        ;
        $serviceMock = $this->getServiceMock();

        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($serviceMock)
        ;

        $service = $factory->create($value, $serviceDefinition);

        self::assertSame($service, $serviceMock);
    }

    protected function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }

    private function getServiceMock(): MockObject&IService
    {
        return $this->createMock(IService::class);
    }
}
