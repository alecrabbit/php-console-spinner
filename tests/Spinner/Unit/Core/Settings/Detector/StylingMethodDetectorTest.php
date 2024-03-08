<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingModeOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\StylingMethodDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub\NegativeStylingMethodProbeStub;
use AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Stub\PositiveStylingMethodProbeStub;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class StylingMethodDetectorTest extends TestCase
{
    public static function canDetectDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [
                StylingModeOption::NONE,
                [],
            ],
            [
                StylingModeOption::ANSI24,
                [
                    PositiveStylingMethodProbeStub::class,
                ],
            ],
            [
                StylingModeOption::ANSI24,
                [
                    NegativeStylingMethodProbeStub::class,
                    PositiveStylingMethodProbeStub::class,
                ],
            ],
            [
                StylingModeOption::NONE,
                [
                    NegativeStylingMethodProbeStub::class,
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(StylingMethodDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): IStylingMethodDetector {
        return
            new StylingMethodDetector(
                probes: $probes ?? new ArrayObject(),
            );
    }

    #[Test]
    #[DataProvider('canDetectDataProvider')]
    public function canDetect(StylingModeOption $result, array $probes): void
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
                IStylingMethodProbe::class
            )
        );
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject([stdClass::class]),
        );
        self::assertEquals(StylingModeOption::AUTO, $detector->getSupportValue());

        self::fail('Exception was not thrown.');
    }
}
