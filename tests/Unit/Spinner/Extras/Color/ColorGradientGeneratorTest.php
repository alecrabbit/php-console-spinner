<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Extras\Color\ColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\ColorProcessor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorGradientGeneratorTest extends TestCaseWithPrebuiltMocksAndStubs
{

    public static function canConvertToRgbFromHexStringDataProvider(): iterable
    {
        yield from [
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(255, 255, 255),
                ],
                ['#000', '#fff', 2],
            ],
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(255, 255, 255),
                ],
                ['#000', '#fff'],
            ],
            [
                [
                    new RGBColor(0, 0, 0, 0),
                    new RGBColor(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)', 2],
            ],
            [
                [
                    new RGBColor(0, 0, 0, 0),
                    new RGBColor(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)',],
            ],
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(128, 128, 128),
                    new RGBColor(255, 255, 255),
                ],
                ['#000', '#fff', 3],
            ],
            [
                [
                    new RGBColor(0, 0, 0, 0),
                    new RGBColor(128, 128, 128, 0.5),
                    new RGBColor(255, 255, 255, 1),
                ],
                ['rgba(0, 0, 0, 0)', 'rgba(255, 255, 255, 1)', 3],
            ],
            [
                [
                    new RGBColor(174, 67, 18, 1.0),
                    new RGBColor(190, 54, 21, 1.0),
                    new RGBColor(206, 40, 24, 1.0),
                    new RGBColor(223, 27, 28, 1.0),
                    new RGBColor(239, 13, 31, 1.0),
                    new RGBColor(255, 0, 34, 1.0),

                ],
                ['#ae4312', '#ff0022', 6],
            ],
            [
                [
                    new RGBColor(174, 67, 18, 0.0),
                    new RGBColor(190, 54, 21, 0.2),
                    new RGBColor(206, 40, 24, 0.4),
                    new RGBColor(223, 27, 28, 0.6),
                    new RGBColor(239, 13, 31, 0.8),
                    new RGBColor(255, 0, 34, 1.0),

                ],
                ['rgba(174, 67, 18, 0)', 'rgba(255, 0, 34, 1)', 6],
            ],
        ];
    }

    public function canBeCreated(): void
    {
        $processor = $this->getTesteeInstance();

        self::assertInstanceOf(ColorProcessor::class, $processor);
    }

    public function getTesteeInstance(
        ?IColorProcessor $colorProcessor = null,
    ): IColorGradientGenerator {
        return new ColorGradientGenerator(
            colorProcessor: $colorProcessor ?? new ColorProcessor(),
        );
    }

    #[Test]
    #[DataProvider('canConvertToRgbFromHexStringDataProvider')]
    public function canGenerateGradientsFromStringColors(array $expected, array $incoming): void
    {
        $generator = $this->getTesteeInstance();

        $result = $generator->gradient(...$incoming);

        self::assertEquals($expected, iterator_to_array($result));
    }

    private function dump(array $iterator_to_array): array
    {
        echo PHP_EOL;
        /** @var RGBColor $item */
        foreach ($iterator_to_array as $item) {
            echo sprintf(
                'new RGBColor(%d, %d, %d, %02f),' . PHP_EOL,
                $item->red,
                $item->green,
                $item->blue,
                $item->alpha
            );
        }
        echo PHP_EOL;

        return $iterator_to_array;
    }
}
