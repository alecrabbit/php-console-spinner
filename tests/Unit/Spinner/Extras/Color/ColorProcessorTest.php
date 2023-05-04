<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\ColorProcessor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use AlecRabbit\Spinner\Extras\Color\HSLColor;
use AlecRabbit\Spinner\Extras\Color\RGBColor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorProcessorTest extends TestCaseWithPrebuiltMocksAndStubs
{

    public static function canConvertToRgbFromHexStringDataProvider(): iterable
    {
        yield from [
            [new RGBColor(245, 197, 215), '#f5c5d7',],
            [new RGBColor(22, 0, 215), '#1600d7',],
            [new RGBColor(38, 247, 209), '#26f7d1',],
            [new RGBColor(74, 247, 204), '#4af7cc',],
        ];
    }

    public static function canConvertToHslFromHexStringDataProvider(): iterable
    {
        yield from [
            [new HSLColor(338, 0.71, 0.87, 1), '#f5c5d7',],
            [new HSLColor(246, 1, 0.42), '#1600d7',],
            [new HSLColor(33, 1, 0.5), '#FF8C00',],
            [new HSLColor(84, 1, 0.6), '#aeff33',], //hsla(84, 100%, 60%, 1)
        ];
    }

    public static function canConvertToRgbFromRgbDataProvider(): iterable
    {
        yield from [
            [$color = new RGBColor(22, 0, 215), $color,],
            [$color = new RGBColor(0, 0, 0, 0.5), $color,],
        ];
    }

    public static function canConvertToHslFromHslDataProvider(): iterable
    {
        yield from [
            [$color = new HSLColor(246, 1, 0.42), $color,],
            [$color = new HSLColor(33, 1, 0.5), $color,],
        ];
    }

    public static function canConvertToRgbFromHslStringDataProvider(): iterable
    {
        yield from [
            [new RGBColor(74, 247, 204), 'hsl(165, 92%, 63%)',],
            [new RGBColor(74, 247, 204, 1), 'hsla(165, 92%, 63%, 1)',],
        ];
    }

    public static function canConvertToRgbFromRgbStringDataProvider(): iterable
    {
        yield from [
            [new RGBColor(74, 247, 204), 'rgb(74, 247, 204)',],
            [new RGBColor(74, 247, 204, 1), 'rgb(74, 247, 204, 1)',],
            [new RGBColor(74, 247, 204, 0.6), 'rgb(74, 247, 204, 0.6)',],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $processor = $this->getTesteeInstance();

        self::assertInstanceOf(ColorProcessor::class, $processor);
    }

    public function getTesteeInstance(
        ?int $floatPrecision = null,
    ): IColorProcessor {
        return new ColorProcessor(
            floatPrecision: $floatPrecision ?? 2
        );
    }

    #[Test]
    #[DataProvider('canConvertToRgbFromHexStringDataProvider')]
    public function canConvertToRgbFromHexString(IColor $expected, string $incoming): void
    {
        $processor = $this->getTesteeInstance();

        $result = $processor->toRGB($incoming);

        self::assertEquals($expected, $result);
    }

    #[Test]
    #[DataProvider('canConvertToHslFromHexStringDataProvider')]
    public function canConvertToHslFromHexString(IColor $expected, string $incoming): void
    {
        $processor = $this->getTesteeInstance();

        $result = $processor->toHSL($incoming);

        self::assertEquals($expected, $result);
    }

    #[Test]
    #[DataProvider('canConvertToRgbFromRgbDataProvider')]
    public function canConvertToRgbFromRgb(IColor $expected, IColor $incoming): void
    {
        $processor = $this->getTesteeInstance();

        $result = $processor->toRGB($incoming);

        self::assertSame($expected, $result);
    }

    #[Test]
    #[DataProvider('canConvertToHslFromHslDataProvider')]
    public function canConvertToHslFromHsl(IColor $expected, IColor $incoming): void
    {
        $processor = $this->getTesteeInstance();

        $result = $processor->toHSL($incoming);

        self::assertSame($expected, $result);
    }

    #[Test]
    #[DataProvider('canConvertToRgbFromHslStringDataProvider')]
    public function canConvertToRgbFromHslString(IColor $expected, string $incoming): void
    {
        $processor = $this->getTesteeInstance();


        $result = $processor->toRGB($incoming);

        self::assertEquals($expected, $result);
    }

    #[Test]
    #[DataProvider('canConvertToRgbFromRgbStringDataProvider')]
    public function canConvertToRgbFromRgbString(IColor $expected, string $incoming): void
    {
        $processor = $this->getTesteeInstance();


        $result = $processor->toRGB($incoming);

        self::assertEquals($expected, $result);
    }

    #[Test]
    public function canSetCustomPrecision(): void
    {
        $floatPrecision = 3;

        $processor = $this->getTesteeInstance(
            floatPrecision: $floatPrecision
        );

        self::assertSame($floatPrecision, $processor->getFloatPrecision());
    }
}
