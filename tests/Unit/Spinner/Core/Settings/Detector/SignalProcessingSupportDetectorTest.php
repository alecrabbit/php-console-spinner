<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalProcessingSupportDetector;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeSignalProcessingProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveSignalProcessingProbeOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class SignalProcessingSupportDetectorTest extends TestCase
{
    public static function canDetectDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [SignalHandlersOption::DISABLED, []],
            [
                SignalHandlersOption::ENABLED,
                [
                    PositiveSignalProcessingProbeOverride::class,
                ]
            ],
            [
                SignalHandlersOption::ENABLED,
                [
                    NegativeSignalProcessingProbeOverride::class,
                    PositiveSignalProcessingProbeOverride::class,
                ]
            ],
            [
                SignalHandlersOption::DISABLED,
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

        self::assertInstanceOf(SignalProcessingSupportDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): ISignalProcessingSupportDetector {
        return
            new SignalProcessingSupportDetector(
                probes: $probes ?? new ArrayObject(),
            );
    }

    #[Test]
    #[DataProvider('canDetectDataProvider')]
    public function canDetect(SignalHandlersOption $result, array $probes): void
    {
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject($probes),
        );

        self::assertEquals($result, $detector->getSupportValue());
    }

//    #[Test]
//    public function throwsIfProbeIsInvalid(): void
//    {
//        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage(
//            sprintf(
//                'Probe must be an instance of "%s" interface.',
//                ISignalProcessingProbe::class
//            )
//        );
//        $detector = $this->getTesteeInstance(
//            probes: new ArrayObject([stdClass::class]),
//        );
//        self::assertTrue($detector->isSupported());
//
//        self::fail('Exception was not thrown.');
//    }
}
