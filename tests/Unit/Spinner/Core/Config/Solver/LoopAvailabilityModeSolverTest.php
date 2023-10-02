<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\LoopAvailabilityMode;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ILoopAvailabilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\LoopAvailabilityModeSolver;
use AlecRabbit\Spinner\Probes;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver\Override\NegativeLoopProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Config\Solver\Override\PositiveLoopProbeOverride;
use PHPUnit\Framework\Attributes\Test;

final class LoopAvailabilityModeSolverTest extends TestCase
{
    private const PROBES = 'probes';
    private static array $probes;

    #[Test]
    public function canBeInstantiated(): void
    {
        $solver = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAvailabilityModeSolver::class, $solver);
    }

    protected function getTesteeInstance(): ILoopAvailabilityModeSolver
    {
        return
            new LoopAvailabilityModeSolver();
    }

    #[Test]
    public function canSolveWhenLoopIsUnavailable(): void
    {
        $probes = [
            NegativeLoopProbeOverride::class,
        ];
        $this->setProbes($probes);

        $solver = $this->getTesteeInstance();

        self::assertEquals(LoopAvailabilityMode::NONE, $solver->solve());
    }

    #[Test]
    public function canSolveWhenLoopIsAvailable(): void
    {
        $probes = [
            NegativeLoopProbeOverride::class,
            PositiveLoopProbeOverride::class,
        ];

        $this->setProbes($probes);

        $solver = $this->getTesteeInstance();

        self::assertEquals(LoopAvailabilityMode::AVAILABLE, $solver->solve());
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$probes = self::getPropertyValue(self::PROBES, Probes::class);
    }

    protected function tearDown(): void
    {
        $this->setProbes(self::$probes);
        parent::tearDown();
    }

    protected function setProbes(array $probes): void
    {
        self::setPropertyValue(Probes::class, self::PROBES, $probes);
    }


}
