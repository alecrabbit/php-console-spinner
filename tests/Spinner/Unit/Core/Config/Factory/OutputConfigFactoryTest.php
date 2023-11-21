<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class OutputConfigFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(OutputConfigFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IStylingMethodModeSolver $stylingMethodModeSolver = null,
        ?ICursorVisibilityModeSolver $cursorVisibilityModeSolver = null,
        ?IInitializationModeSolver $initializationModeSolver = null,
        ?IStreamSolver $streamSolver = null,
        ?IOutputConfigBuilder $outputConfigBuilder = null,
    ): IOutputConfigFactory {
        return
            new OutputConfigFactory(
                stylingMethodModeSolver: $stylingMethodModeSolver ?? $this->getStylingMethodModeSolverMock(),
                cursorVisibilityModeSolver: $cursorVisibilityModeSolver ?? $this->getCursorVisibilityModeSolverMock(),
                initializationModeSolver: $initializationModeSolver ?? $this->getInitializationModeSolverMock(),
                streamSolver: $streamSolver ?? $this->getStreamSolverMock(),
                outputConfigBuilder: $outputConfigBuilder ?? $this->getOutputConfigBuilderMock(),
            );
    }

//

    protected function getStylingMethodModeSolverMock(
        ?StylingMethodMode $stylingMethodMode = null,
    ): MockObject&IStylingMethodModeSolver {
        return
            $this->createConfiguredMock(
                IStylingMethodModeSolver::class,
                [
                    'solve' => $stylingMethodMode ?? StylingMethodMode::ANSI8,
                ]
            );
    }

    protected function getCursorVisibilityModeSolverMock(
        ?CursorVisibilityMode $cursorVisibilityMode = null,
    ): MockObject&ICursorVisibilityModeSolver {
        return
            $this->createConfiguredMock(
                ICursorVisibilityModeSolver::class,
                [
                    'solve' => $cursorVisibilityMode ?? CursorVisibilityMode::HIDDEN,
                ]
            );
    }

    private function getInitializationModeSolverMock(
        ?InitializationMode $initializationMode = null,
    ): MockObject&IInitializationModeSolver {
        return $this->createConfiguredMock(
            IInitializationModeSolver::class,
            [
                'solve' => $initializationMode ?? InitializationMode::DISABLED,
            ]
        );
    }

    private function getStreamSolverMock(mixed $stream = STDOUT): MockObject&IStreamSolver
    {
        return $this->createConfiguredMock(IStreamSolver::class, [
                'solve' => $stream,
            ]
        );
    }

    protected function getOutputConfigBuilderMock(): MockObject&IOutputConfigBuilder
    {
        return $this->createMock(IOutputConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $stylingMethodMode = StylingMethodMode::ANSI4;
        $cursorVisibilityMode = CursorVisibilityMode::VISIBLE;
        $initializationMode = InitializationMode::DISABLED;
        $stream = STDOUT;

        $outputConfig =
            $this->getOutputConfigMock(
                $stylingMethodMode,
                $cursorVisibilityMode,
                $initializationMode,
                $stream,
            );

        $outputConfigBuilder = $this->getOutputConfigBuilderMock();
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withStylingMethodMode')
            ->with($stylingMethodMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withCursorVisibilityMode')
            ->with($cursorVisibilityMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withInitializationMode')
            ->with($initializationMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withStream')
            ->with($stream)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($outputConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                stylingMethodModeSolver: $this->getStylingMethodModeSolverMock($stylingMethodMode),
                cursorVisibilityModeSolver: $this->getCursorVisibilityModeSolverMock($cursorVisibilityMode),
                initializationModeSolver: $this->getInitializationModeSolverMock($initializationMode),
                streamSolver: $this->getStreamSolverMock($stream),
                outputConfigBuilder: $outputConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($outputConfig, $config);

        self::assertSame($stylingMethodMode, $config->getStylingMethodMode());
        self::assertSame($cursorVisibilityMode, $config->getCursorVisibilityMode());
    }

    protected function getOutputConfigMock(
        ?StylingMethodMode $stylingMethodMode = null,
        ?CursorVisibilityMode $cursorVisibilityMode = null,
        ?InitializationMode $initializationMode = null,
        mixed $stream = null,
    ): MockObject&IOutputConfig {
        return
            $this->createConfiguredMock(
                IOutputConfig::class,
                [
                    'getStylingMethodMode' => $stylingMethodMode ?? StylingMethodMode::ANSI8,
                    'getCursorVisibilityMode' => $cursorVisibilityMode ?? CursorVisibilityMode::HIDDEN,
                    'getInitializationMode' => $initializationMode ?? InitializationMode::DISABLED,
                    'getStream' => $stream,
                ]
            );
    }
}
