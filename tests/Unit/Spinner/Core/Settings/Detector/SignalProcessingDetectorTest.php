<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalProcessingDetector;
use AlecRabbit\Spinner\Probes;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeSignalProcessingProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveSignalProcessingProbeOverride;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class SignalProcessingDetectorTest extends TestCase
{
    private const PROBES = 'probes';
    private static array $probes;

    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [false, []],
            [
                true,
                [
                    PositiveSignalProcessingProbeOverride::class,
                ]
            ],
            [
                true,
                [
                    NegativeSignalProcessingProbeOverride::class,
                    PositiveSignalProcessingProbeOverride::class,
                ]
            ],
            [
                false,
                [
                    NegativeSignalProcessingProbeOverride::class,
                ]
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(SignalProcessingDetector::class, $detector);
    }

    protected function getTesteeInstance(): ISignalProcessingDetector
    {
        return
            new SignalProcessingDetector();
    }

    #[Test]
    #[DataProvider('canSolveDataProvider')]
    public function canSolve(bool $result, array $probes): void
    {
        $this->setProbes($probes);

        $detector = $this->getTesteeInstance();

        self::assertEquals($result, $detector->isSupported());
    }

    protected function setProbes(array $probes): void
    {
        self::setPropertyValue(Probes::class, self::PROBES, $probes);
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
