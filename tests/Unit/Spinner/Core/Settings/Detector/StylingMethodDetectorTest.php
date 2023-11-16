<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\StylingMethodDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeStylingMethodProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveStylingMethodProbeOverride;
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
                StylingMethodOption::NONE,
                [],
            ],
            [
                StylingMethodOption::ANSI24,
                [
                    PositiveStylingMethodProbeOverride::class,
                ],
            ],
            [
                StylingMethodOption::ANSI24,
                [
                    NegativeStylingMethodProbeOverride::class,
                    PositiveStylingMethodProbeOverride::class,
                ],
            ],
            [
                StylingMethodOption::NONE,
                [
                    NegativeStylingMethodProbeOverride::class,
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
    public function canDetect(StylingMethodOption $result, array $probes): void
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
        self::assertEquals(StylingMethodOption::AUTO, $detector->getSupportValue());

        self::fail('Exception was not thrown.');
    }
}
