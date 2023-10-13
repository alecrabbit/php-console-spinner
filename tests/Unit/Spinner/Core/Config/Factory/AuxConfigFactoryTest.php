<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AuxConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(AuxConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IRunMethodModeSolver $runMethodModeSolver = null,
        ?INormalizerMethodModeSolver $normalizerMethodModeSolver = null,
        ?IAuxConfigBuilder $auxConfigBuilder = null,
    ): IAuxConfigFactory {
        return
            new AuxConfigFactory(
                runMethodModeSolver: $runMethodModeSolver ?? $this->getRunMethodModeSolverMock(),
                normalizerMethodModeSolver: $normalizerMethodModeSolver ?? $this->getNormalizerMethodModeSolverMock(),
                auxConfigBuilder: $auxConfigBuilder ?? $this->getAuxConfigBuilderMock(),
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

    protected function getNormalizerMethodModeSolverMock(?NormalizerMethodMode $normalizerMethodMode = null
    ): MockObject&INormalizerMethodModeSolver {
        return
            $this->createConfiguredMock(
                INormalizerMethodModeSolver::class,
                [
                    'solve' => $normalizerMethodMode ?? NormalizerMethodMode::STILL,
                ]
            );
    }

    protected function getAuxConfigBuilderMock(): MockObject&IAuxConfigBuilder
    {
        return $this->createMock(IAuxConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $runMethodMode = RunMethodMode::ASYNC;
        $normalizerMethodMode = NormalizerMethodMode::BALANCED;

        $auxConfig =
            $this->getAuxConfigMock(
                $runMethodMode,
                $normalizerMethodMode
            );

        $auxConfigBuilder = $this->getAuxConfigBuilderMock();
        $auxConfigBuilder
            ->expects(self::once())
            ->method('withRunMethodMode')
            ->with($runMethodMode)
            ->willReturnSelf()
        ;
        $auxConfigBuilder
            ->expects(self::once())
            ->method('withNormalizerMethodMode')
            ->with($normalizerMethodMode)
            ->willReturnSelf()
        ;
        $auxConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($auxConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                runMethodModeSolver: $this->getRunMethodModeSolverMock($runMethodMode),
                normalizerMethodModeSolver: $this->getNormalizerMethodModeSolverMock($normalizerMethodMode),
                auxConfigBuilder: $auxConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($auxConfig, $config);

        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($normalizerMethodMode, $config->getNormalizerMethodMode());
    }

    private function getAuxConfigMock(
        RunMethodMode $runMethodMode,
        NormalizerMethodMode $normalizerMethodMode,
    ): MockObject&IAuxConfig {
        return
            $this->createConfiguredMock(
                IAuxConfig::class,
                [
                    'getRunMethodMode' => $runMethodMode,
                    'getNormalizerMethodMode' => $normalizerMethodMode,
                ]
            );
    }
}
