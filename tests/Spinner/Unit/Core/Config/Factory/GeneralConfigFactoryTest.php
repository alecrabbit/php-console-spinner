<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IGeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\Factory\GeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IExecutionModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class GeneralConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(GeneralConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IExecutionModeSolver $executionModeSolver = null,
        ?IGeneralConfigBuilder $generalConfigBuilder = null,
    ): IGeneralConfigFactory {
        return
            new GeneralConfigFactory(
                executionModeSolver: $executionModeSolver ?? $this->getExecutionModeSolverMock(),
                generalConfigBuilder: $generalConfigBuilder ?? $this->getGeneralConfigBuilderMock(),
            );
    }

    protected function getExecutionModeSolverMock(?ExecutionMode $executionMode = null
    ): MockObject&IExecutionModeSolver {
        return
            $this->createConfiguredMock(
                IExecutionModeSolver::class,
                [
                    'solve' => $executionMode ?? ExecutionMode::SYNCHRONOUS,
                ]
            );
    }

    protected function getGeneralConfigBuilderMock(): MockObject&IGeneralConfigBuilder
    {
        return $this->createMock(IGeneralConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $executionMode = ExecutionMode::ASYNC;

        $generalConfig =
            $this->getGeneralConfigMock(
                $executionMode,
            );

        $generalConfigBuilder = $this->getGeneralConfigBuilderMock();
        $generalConfigBuilder
            ->expects(self::once())
            ->method('withExecutionMode')
            ->with($executionMode)
            ->willReturnSelf()
        ;
        $generalConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($generalConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                executionModeSolver: $this->getExecutionModeSolverMock($executionMode),
                generalConfigBuilder: $generalConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($generalConfig, $config);

        self::assertSame($executionMode, $config->getExecutionMode());
    }

    private function getGeneralConfigMock(
        ExecutionMode $executionMode,
    ): MockObject&IGeneralConfig {
        return
            $this->createConfiguredMock(
                IGeneralConfig::class,
                [
                    'getExecutionMode' => $executionMode,
                ]
            );
    }
}
