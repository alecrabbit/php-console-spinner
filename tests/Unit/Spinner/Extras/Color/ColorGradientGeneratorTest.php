<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\ColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\ColorProcessor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use AlecRabbit\Spinner\Extras\Color\RGBColor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorGradientGeneratorTest extends TestCaseWithPrebuiltMocksAndStubs
{

    public static function canProduceGradientDataProvider(): iterable
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
                ['rgba(0, 0, 0, 0)', new RGBColor(255, 255, 255, 1), 3],
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
                [new RGBColor(174, 67, 18, 1.0), '#ff0022', 6],
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

    public static function canProduceGradientsDataProvider(): iterable
    {
        yield from [
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff']),],
            ],
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(128, 128, 128),
                    new RGBColor(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3,],
            ],
            [
                [
                    new RGBColor(0, 0, 0),
                    new RGBColor(0, 0, 0),
                    new RGBColor(0, 0, 0),
                    new RGBColor(0, 0, 0),
                    new RGBColor(128, 128, 128),
                    new RGBColor(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3, '#000'],
            ],
            [
                [
                    new RGBColor(255, 255, 255),
                    new RGBColor(128, 128, 128),
                    new RGBColor(0, 0, 0),
                    new RGBColor(0, 0, 0),
                    new RGBColor(128, 128, 128),
                    new RGBColor(255, 255, 255),
                ],
                [new ArrayObject(['#000', '#fff'],), 3, '#fff'],
            ],
            [
                [
                    new RGBColor(255, 255, 255, 1.000000),
                    new RGBColor(170, 170, 170, 1.000000),
                    new RGBColor(85, 85, 85, 1.000000),
                    new RGBColor(0, 0, 0, 1.000000),
                    new RGBColor(0, 0, 0, 1.000000),
                    new RGBColor(85, 85, 85, 1.000000),
                    new RGBColor(170, 170, 170, 1.000000),
                    new RGBColor(255, 255, 255, 1.000000),

                ],
                [new ArrayObject(['#000', '#fff'],), 4, '#fff'],
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
        ?int $maxColors = null,
    ): IColorGradientGenerator {
        return new ColorGradientGenerator(
            colorProcessor: $colorProcessor ?? new ColorProcessor(),
            maxColors: $maxColors ?? 100,
        );
    }

    #[Test]
    #[DataProvider('canProduceGradientDataProvider')]
    public function canGenerateGradientFromColors(array $expected, array $incoming): void
    {
        $generator = $this->getTesteeInstance();

        $result = $generator->gradient(...$incoming);

        self::assertEquals($expected, iterator_to_array($result));
    }

    #[Test]
    #[DataProvider('canProduceGradientsDataProvider')]
    public function canGenerateGradientsFromColors(array $expected, array $incoming): void
    {
        $generator = $this->getTesteeInstance();

        $result = [];

        foreach ($generator->gradients(...$incoming) as $item) {
            $result[] = $item;
        }
        $this->dump($result);

        self::assertEquals($expected, $result);
    }

    private function dump(array $result): void
    {
        $s = PHP_EOL;
        foreach ($result as $item) {
            $s .= sprintf(
                'new RGBColor(%d, %d, %d, %02f),' . PHP_EOL,
                $item->red,
                $item->green,
                $item->blue,
                $item->alpha
            );
        }
//        dump($s);
    }

    #[Test]
    public function throwsIfCountLessThenTwo(): void
    {
        $e = new InvalidArgumentException('Number of colors must be greater than 2.');

        $test = function () {
            $generator = $this->getTesteeInstance();

            $result = $generator->gradient('#000', '#fff', 1);

            iterator_to_array($result); // unwrap Generator
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $e,
        );
    }

    #[Test]
    public function throwsIfCountGreaterThenMax(): void
    {
        $e = new InvalidArgumentException('Number of colors must be less than 5.');

        $test = function () {
            $generator = $this->getTesteeInstance(
                maxColors: 5,
            );

            $result = $generator->gradient('#000', '#fff', 6);

            iterator_to_array($result); // unwrap Generator
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $e,
        );
    }
}
