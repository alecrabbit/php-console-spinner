<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopAvailabilityDetector;
use AlecRabbit\Spinner\Probes;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeLoopProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveLoopProbeOverride;
use PHPUnit\Framework\Attributes\Test;

final class LoopAvailabilityDetectorTest extends TestCase
{
    private const PROBES = 'probes';
    private static array $probes;

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAvailabilityDetector::class, $detector);
    }

    protected function getTesteeInstance(): ILoopAvailabilityDetector
    {
        return
            new LoopAvailabilityDetector();
    }

    #[Test]
    public function canSolveWhenLoopIsUnavailable(): void
    {
        $probes = [
            NegativeLoopProbeOverride::class,
        ];
        $this->setProbes($probes);

        $detector = $this->getTesteeInstance();

        self::assertFalse($detector->loopIsAvailable());
    }

    protected function setProbes(array $probes): void
    {
        self::setPropertyValue(Probes::class, self::PROBES, $probes);
    }

    #[Test]
    public function canSolveWhenLoopIsAvailable(): void
    {
        $probes = [
            NegativeLoopProbeOverride::class,
            PositiveLoopProbeOverride::class,
        ];

        $this->setProbes($probes);

        $detector = $this->getTesteeInstance();

        self::assertTrue($detector->loopIsAvailable());
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
}
