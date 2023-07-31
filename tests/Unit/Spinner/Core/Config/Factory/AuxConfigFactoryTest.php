<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\ILoopAvailabilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Factory\AuxConfigFactory;
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
        ?ILoopAvailabilityModeSolver $loopAvailabilityModeSolver = null,
        ?INormalizerMethodModeSolver $normalizerMethodModeSolver = null,
    ): IAuxConfigFactory {
        return
            new AuxConfigFactory(
                runMethodModeSolver: $runMethodModeSolver ?? $this->getRunMethodModeSolverMock(),
                loopAvailabilityModeSolver: $loopAvailabilityModeSolver ?? $this->getLoopAvailabilityModeSolverMock(),
                normalizerMethodModeSolver: $normalizerMethodModeSolver ?? $this->getNormalizerMethodModeSolverMock(),
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

    protected function getLoopAvailabilityModeSolverMock(?LoopAvailabilityMode $loopAvailabilityMode = null
    ): MockObject&ILoopAvailabilityModeSolver {
        return
            $this->createConfiguredMock(
                ILoopAvailabilityModeSolver::class,
                [
                    'solve' => $loopAvailabilityMode ?? LoopAvailabilityMode::NONE,
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

    #[Test]
    public function canCreate(): void
    {
        $runMethodMode = RunMethodMode::ASYNC;
        $loopAvailabilityMode = LoopAvailabilityMode::AVAILABLE;
        $normalizerMethodMode = NormalizerMethodMode::BALANCED;

        $factory =
            $this->getTesteeInstance(
                runMethodModeSolver: $this->getRunMethodModeSolverMock($runMethodMode),
                loopAvailabilityModeSolver: $this->getLoopAvailabilityModeSolverMock($loopAvailabilityMode),
                normalizerMethodModeSolver: $this->getNormalizerMethodModeSolverMock($normalizerMethodMode),
            );

        $config = $factory->create();

        self::assertInstanceOf(AuxConfig::class, $config);

        self::assertSame($runMethodMode, $config->getRunMethodMode());
        self::assertSame($loopAvailabilityMode, $config->getLoopAvailabilityMode());
        self::assertSame($normalizerMethodMode, $config->getNormalizerMethodMode());
    }
}
