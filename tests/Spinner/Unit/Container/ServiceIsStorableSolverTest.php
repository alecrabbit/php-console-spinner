<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Container;

use AlecRabbit\Spinner\Container\Contract\IIsStorableSolver;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\ServiceIsStorableSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ServiceIsStorableSolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $service = $this->getTesteeInstance();

        self::assertInstanceOf(ServiceIsStorableSolver::class, $service);
    }

    protected function getTesteeInstance(): IIsStorableSolver
    {
        return
            new ServiceIsStorableSolver();
    }

    #[Test]
    public function canDefineIsStorable(): void
    {
        $solver = $this->getTesteeInstance();

        $definition = $this->getServiceDefinitionMock();
        $definition
            ->expects(self::once())
            ->method('getOptions')
            ->willReturn(0)
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
            ->method('getOptions')
            ->willReturn(1)
        ;

        self::assertFalse($solver->isStorable($definition));
    }
}
