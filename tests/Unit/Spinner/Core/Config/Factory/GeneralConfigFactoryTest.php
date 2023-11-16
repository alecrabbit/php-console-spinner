<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IGeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\Factory\GeneralConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
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
        ?IRunMethodModeSolver $runMethodModeSolver = null,
        ?IGeneralConfigBuilder $generalConfigBuilder = null,
    ): IGeneralConfigFactory {
        return
            new GeneralConfigFactory(
                runMethodModeSolver: $runMethodModeSolver ?? $this->getRunMethodModeSolverMock(),
                generalConfigBuilder: $generalConfigBuilder ?? $this->getGeneralConfigBuilderMock(),
            );
    }

    protected function getRunMethodModeSolverMock(?RunMethodMode $runMethodMode = null
    ): MockObject&IRunMethodModeSolver {
        return
            $this->createConfiguredMock(
                IRunMethodModeSolver::class,
                [
                    'solve' => $runMethodMode ?? RunMethodMode::SYNCHRONOUS,
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
        $runMethodMode = RunMethodMode::ASYNC;

        $generalConfig =
            $this->getGeneralConfigMock(
                $runMethodMode,
            );

        $generalConfigBuilder = $this->getGeneralConfigBuilderMock();
        $generalConfigBuilder
            ->expects(self::once())
            ->method('withRunMethodMode')
            ->with($runMethodMode)
            ->willReturnSelf()
        ;
        $generalConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($generalConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                runMethodModeSolver: $this->getRunMethodModeSolverMock($runMethodMode),
                generalConfigBuilder: $generalConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($generalConfig, $config);

        self::assertSame($runMethodMode, $config->getRunMethodMode());
    }

    private function getGeneralConfigMock(
        RunMethodMode $runMethodMode,
    ): MockObject&IGeneralConfig {
        return
            $this->createConfiguredMock(
                IGeneralConfig::class,
                [
                    'getRunMethodMode' => $runMethodMode,
                ]
            );
    }
}
