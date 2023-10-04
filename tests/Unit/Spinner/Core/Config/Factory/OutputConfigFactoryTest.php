<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Factory\OutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
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
        ?IOutputConfigBuilder $outputConfigBuilder = null,
    ): IOutputConfigFactory {
        return
            new OutputConfigFactory(
                stylingMethodModeSolver: $stylingMethodModeSolver ?? $this->getStylingMethodModeSolverMock(),
                cursorVisibilityModeSolver: $cursorVisibilityModeSolver ?? $this->getCursorVisibilityModeSolverMock(),
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

    protected function getOutputConfigBuilderMock(): MockObject&IOutputConfigBuilder
    {
        return $this->createMock(IOutputConfigBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $stylingMethodMode = StylingMethodMode::ANSI4;
        $cursorVisibilityMode = CursorVisibilityMode::VISIBLE;

        $outputConfig =
            $this->getOutputConfigMock(
                $stylingMethodMode,
                $cursorVisibilityMode
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
            ->method('build')
            ->willReturn($outputConfig)
        ;

        $factory =
            $this->getTesteeInstance(
                stylingMethodModeSolver: $this->getStylingMethodModeSolverMock($stylingMethodMode),
                cursorVisibilityModeSolver: $this->getCursorVisibilityModeSolverMock($cursorVisibilityMode),
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
    ): MockObject&IOutputConfig {
        return
            $this->createConfiguredMock(
                IOutputConfig::class,
                [
                    'getStylingMethodMode' => $stylingMethodMode ?? StylingMethodMode::ANSI8,
                    'getCursorVisibilityMode' => $cursorVisibilityMode ?? CursorVisibilityMode::HIDDEN,
                ]
            );
    }
}
