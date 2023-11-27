<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalHandlingSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override\NegativeSignalHandlingProbeOverride;
use AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override\PositiveSignalHandlingProbeOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class SignalHandlingSupportDetectorTest extends TestCase
{
    public static function canDetectDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [SignalHandlingOption::DISABLED, []],
            [
                SignalHandlingOption::ENABLED,
                [
                    PositiveSignalHandlingProbeOverride::class,
                ]
            ],
            [
                SignalHandlingOption::ENABLED,
                [
                    NegativeSignalHandlingProbeOverride::class,
                    PositiveSignalHandlingProbeOverride::class,
                ]
            ],
            [
                SignalHandlingOption::DISABLED,
                [
                    NegativeSignalHandlingProbeOverride::class,
                ]
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlingSupportDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): ISignalHandlingSupportDetector {
        return
            new SignalHandlingSupportDetector(
                probes: $probes ?? new ArrayObject(),
            );
    }

    #[Test]
    #[DataProvider('canDetectDataProvider')]
    public function canDetect(SignalHandlingOption $result, array $probes): void
    {
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject($probes),
        );

        self::assertEquals($result, $detector->getSupportValue());
    }

    #[Test]
    public function throwsIfProbeIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Probe must be an instance of "%s" interface.',
                ISignalHandlingProbe::class
            )
        );
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject([stdClass::class]),
        );
        self::assertSame(SignalHandlingOption::ENABLED, $detector->getSupportValue());

        self::fail('Exception was not thrown.');
    }
}
