<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRevolverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Factory\RevolverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IToleranceSolver;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IToleranceSolver $toleranceSolver = null,
        ?IRevolverConfigBuilder $revolverConfigBuilder = null,
    ): IRevolverConfigFactory {
        return
            new RevolverConfigFactory(
                toleranceSolver: $toleranceSolver ?? $this->getToleranceSolverMock(),
                revolverConfigBuilder: $revolverConfigBuilder ?? $this->getRevolverConfigBuilderMock(),
            );
    }

    private function getToleranceSolverMock(): MockObject&IToleranceSolver
    {
        return $this->createMock(IToleranceSolver::class);
    }

    protected function getRevolverConfigBuilderMock(): MockObject&IRevolverConfigBuilder
    {
        return $this->createMock(IRevolverConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $tolerance = $this->getToleranceMock();
        $revolverConfig = $this->getRevolverConfigMock();

        $toleranceSolver = $this->getToleranceSolverMock();
        $toleranceSolver
            ->expects($this->once())
            ->method('solve')
            ->willReturn($tolerance)
        ;

        $revolverConfigBuilder = $this->getRevolverConfigBuilderMock();
        $revolverConfigBuilder
            ->expects($this->once())
            ->method('withTolerance')
            ->with($tolerance)
            ->willReturnSelf()
        ;
        $revolverConfigBuilder
            ->expects($this->once())
            ->method('build')
            ->willReturn($revolverConfig)
        ;

        $factory = $this->getTesteeInstance(
            toleranceSolver: $toleranceSolver,
            revolverConfigBuilder: $revolverConfigBuilder,
        );
        $factory->create();
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }
}
