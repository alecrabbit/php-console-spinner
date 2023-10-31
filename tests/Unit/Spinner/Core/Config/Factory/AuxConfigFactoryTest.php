<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
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
        ?INormalizerModeSolver $normalizerModeSolver = null,
        ?IAuxConfigBuilder $auxConfigBuilder = null,
    ): IAuxConfigFactory {
        return
            new AuxConfigFactory(
                runMethodModeSolver: $runMethodModeSolver ?? $this->getRunMethodModeSolverMock(),
                normalizerModeSolver: $normalizerModeSolver ?? $this->getNormalizerModeSolverMock(),
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

    protected function getNormalizerModeSolverMock(?NormalizerMode $normalizerMode = null
    ): MockObject&INormalizerModeSolver {
        return
            $this->createConfiguredMock(
                INormalizerModeSolver::class,
                [
                    'solve' => $normalizerMode ?? NormalizerMode::STILL,
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
        $normalizerMode = NormalizerMode::BALANCED;

        $auxConfig =
            $this->getAuxConfigMock(
                $runMethodMode,
                $normalizerMode
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
            ->method('withNormalizerMode')
            ->with($normalizerMode)
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
                normalizerModeSolver: $this->getNormalizerModeSolverMock($normalizerMode),
                auxConfigBuilder: $auxConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($auxConfig, $config);

        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($normalizerMode, $config->getNormalizerMode());
    }

    private function getAuxConfigMock(
        RunMethodMode $runMethodMode,
        NormalizerMode $normalizerMode,
    ): MockObject&IAuxConfig {
        return
            $this->createConfiguredMock(
                IAuxConfig::class,
                [
                    'getRunMethodMode' => $runMethodMode,
                    'getNormalizerMode' => $normalizerMode,
                ]
            );
    }
}
