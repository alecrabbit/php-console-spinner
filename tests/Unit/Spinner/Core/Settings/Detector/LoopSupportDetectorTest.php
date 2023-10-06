<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeLoopProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveLoopProbeOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class LoopSupportDetectorTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [false, []],
            [
                true,
                [
                    PositiveLoopProbeOverride::class,
                ]
            ],
            [
                true,
                [
                    NegativeLoopProbeOverride::class,
                    PositiveLoopProbeOverride::class,
                ]
            ],
            [
                false,
                [
                    NegativeLoopProbeOverride::class,
                ]
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSupportDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): ILoopSupportDetector {
        return
            new LoopSupportDetector(
                probes: $probes ?? new ArrayObject(),
            );
    }

    #[Test]
    #[DataProvider('canSolveDataProvider')]
    public function canSolve(bool $result, array $probes): void
    {
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject($probes),
        );

        self::assertEquals($result, $detector->isSupported());
    }

    #[Test]
    public function throwsIfProbeIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Probe must be an instance of "%s" interface.',
                ILoopProbe::class
            )
        );
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject([stdClass::class]),
        );
        self::assertTrue($detector->isSupported());

        self::fail('Exception was not thrown.');
    }
}
