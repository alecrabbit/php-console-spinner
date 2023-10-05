<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\ColorSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\NegativeColorSupportProbeOverride;
use AlecRabbit\Tests\Unit\Spinner\Core\Settings\Detector\Override\PositiveColorSupportProbeOverride;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class ColorSupportDetectorTest extends TestCase
{
    public static function canSolveDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [false, []],
            [
                true,
                [
                    PositiveColorSupportProbeOverride::class,
                ]
            ],
            [
                true,
                [
                    NegativeColorSupportProbeOverride::class,
                    PositiveColorSupportProbeOverride::class,
                ]
            ],
            [
                false,
                [
                    NegativeColorSupportProbeOverride::class,
                ]
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(ColorSupportDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?Traversable $probes = null
    ): IColorSupportDetector {
        return
            new ColorSupportDetector(
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
                IColorSupportProbe::class
            )
        );
        $detector = $this->getTesteeInstance(
            probes: new ArrayObject([stdClass::class]),
        );
        self::assertTrue($detector->isSupported());

        self::fail('Exception was not thrown.');
    }
}
