<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingModeSolver;
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
        ?IStylingModeSolver $stylingModeSolver = null,
        ?ICursorModeSolver $cursorVisibilityModeSolver = null,
        ?IInitializationModeSolver $initializationModeSolver = null,
        ?IStreamSolver $streamSolver = null,
        ?IOutputConfigBuilder $outputConfigBuilder = null,
    ): IOutputConfigFactory {
        return
            new OutputConfigFactory(
                stylingModeSolver: $stylingModeSolver ?? $this->getStylingModeSolverMock(),
                cursorVisibilityModeSolver: $cursorVisibilityModeSolver ?? $this->getCursorModeSolverMock(),
                initializationModeSolver: $initializationModeSolver ?? $this->getInitializationModeSolverMock(),
                streamSolver: $streamSolver ?? $this->getStreamSolverMock(),
                outputConfigBuilder: $outputConfigBuilder ?? $this->getOutputConfigBuilderMock(),
            );
    }

//

    protected function getStylingModeSolverMock(
        ?StylingMode $stylingMode = null,
    ): MockObject&IStylingModeSolver {
        return
            $this->createConfiguredMock(
                IStylingModeSolver::class,
                [
                    'solve' => $stylingMode ?? StylingMode::ANSI8,
                ]
            );
    }

    protected function getCursorModeSolverMock(
        ?CursorMode $cursorVisibilityMode = null,
    ): MockObject&ICursorModeSolver {
        return
            $this->createConfiguredMock(
                ICursorModeSolver::class,
                [
                    'solve' => $cursorVisibilityMode ?? CursorMode::HIDDEN,
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
        $stylingMode = StylingMode::ANSI4;
        $cursorVisibilityMode = CursorMode::VISIBLE;
        $initializationMode = InitializationMode::DISABLED;
        $stream = STDOUT;

        $outputConfig =
            $this->getOutputConfigMock(
                $stylingMode,
                $cursorVisibilityMode,
                $initializationMode,
                $stream,
            );

        $outputConfigBuilder = $this->getOutputConfigBuilderMock();
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withStylingMode')
            ->with($stylingMode)
            ->willReturnSelf()
        ;
        $outputConfigBuilder
            ->expects(self::once())
            ->method('withCursorMode')
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
                stylingModeSolver: $this->getStylingModeSolverMock($stylingMode),
                cursorVisibilityModeSolver: $this->getCursorModeSolverMock($cursorVisibilityMode),
                initializationModeSolver: $this->getInitializationModeSolverMock($initializationMode),
                streamSolver: $this->getStreamSolverMock($stream),
                outputConfigBuilder: $outputConfigBuilder,
            );

        $config = $factory->create();

        self::assertSame($outputConfig, $config);

        self::assertSame($stylingMode, $config->getStylingMode());
        self::assertSame($cursorVisibilityMode, $config->getCursorMode());
    }

    protected function getOutputConfigMock(
        ?StylingMode $stylingMode = null,
        ?CursorMode $cursorVisibilityMode = null,
        ?InitializationMode $initializationMode = null,
        mixed $stream = null,
    ): MockObject&IOutputConfig {
        return
            $this->createConfiguredMock(
                IOutputConfig::class,
                [
                    'getStylingMode' => $stylingMode ?? StylingMode::ANSI8,
                    'getCursorMode' => $cursorVisibilityMode ?? CursorMode::HIDDEN,
                    'getInitializationMode' => $initializationMode ?? InitializationMode::DISABLED,
                    'getStream' => $stream,
                ]
            );
    }
}
