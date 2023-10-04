<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalProcessingDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeSignalProcessingProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveSignalProcessingProbeOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class SignalProcessingDetectorTest extends TestCase
{
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

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): ISignalProcessingDetector {
        return
            new SignalProcessingDetector(
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
                ISignalProcessingProbe::class
            )
        );
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject([stdClass::class]),
        );
        self::assertTrue($detector->isSupported());

        self::fail('Exception was not thrown.');
    }
}
