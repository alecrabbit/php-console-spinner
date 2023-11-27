<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container\Factory;

use AlecRabbit\Spinner\Container\Contract\IIsStorableSolver;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceObjectFactory;
use AlecRabbit\Spinner\Container\Factory\ServiceObjectFactory;
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

        self::assertInstanceOf(ServiceObjectFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IIsStorableSolver $isStorableSolver = null,
    ): IServiceObjectFactory {
        return
            new ServiceObjectFactory(
                isStorableSolver: $isStorableSolver ?? $this->getIsStorableSolverMock(),
            );
    }

    private function getIsStorableSolverMock(): MockObject&IIsStorableSolver
    {
        return $this->createMock(IIsStorableSolver::class);
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

        $factory = $this->getTesteeInstance(
            isStorableSolver: $solver,
        );

        $id = self::getFaker()->word();
        $value = new stdClass();
        $serviceDefinition = $this->getServiceDefinitionMock();
        $serviceDefinition
            ->expects(self::once())
            ->method('getId')
            ->willReturn($id);

        $service = $factory->create($value, $serviceDefinition);

        self::assertSame($value, $service->getValue());
        self::assertSame($isStorable, $service->isStorable());
        self::assertSame($id, $service->getId());
    }

    protected function getServiceDefinitionMock(): MockObject&IServiceDefinition
    {
        return $this->createMock(IServiceDefinition::class);
    }
}
