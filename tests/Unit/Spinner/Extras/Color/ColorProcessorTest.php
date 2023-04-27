<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Extras\Color\ColorProcessor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorProcessorTest extends TestCaseWithPrebuiltMocksAndStubs
{

    public static function canConvertToRgbFromHexStringDataProvider(): iterable
    {
        yield from [
            // rgb, color
            [new RGBColor(245, 197, 215), '#f5c5d7',],
            [new RGBColor(22, 0, 215), '#1600d7',],
            [new RGBColor(38, 247, 209), '#26f7d1',],
            [new RGBColor(74, 247, 204), '#4af7cc',],
        ];
    }

    public static function canConvertToRgbFromRgbDataProvider(): iterable
    {
        yield from [
            // rgb, color
            [$color = new RGBColor(22, 0, 215), $color,],
            [$color = new RGBColor(0, 0, 0, 0.5), $color,],
        ];
    }

    public static function canConvertToRgbFromHslStringDataProvider(): iterable
    {
        yield from [
            // rgb, color
            [new RGBColor(74, 247, 204), 'hsl(165, 92%, 63%)',],
            [new RGBColor(74, 247, 204, 1), 'hsla(165, 92%, 63%, 1)',],
        ];
    }

    public static function canConvertToRgbFromRgbStringDataProvider(): iterable
    {
        yield from [
            // rgb, color
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

    public function getTesteeInstance(): IColorProcessor
    {
        return new ColorProcessor();
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
    #[DataProvider('canConvertToRgbFromRgbDataProvider')]
    public function canConvertToRgbFromRgb(IColor $expected, IColor $incoming): void
    {
        $processor = $this->getTesteeInstance();

        $result = $processor->toRGB($incoming);

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
//
//    #[Test]
//    #[DataProvider('invalidInputDataProvider')]
//    public function throwsOnInvalidInput(array $expected, array $incoming): void
//    {
//        $expectedException = $this->expectsException($expected);
//
//        $args = $incoming[self::ARGUMENTS];
//
//        $processor = $this->getTesteeInstance(
//            styleMode: $args[self::STYLE_MODE],
//        );
//
//        $result = $processor->convert($args[self::COLOR]);
//
//        if ($expectedException) {
//            self::failTest($expectedException);
//        }
//
//        self::assertSame($expected[self::RESULT], $result);
//    }
//
//    #[Test]
//    public function throwsIfStyleModeIsNone(): void
//    {
//        $exceptionClass = InvalidArgumentException::class;
//        $exceptionMessage = 'Unsupported style mode "NONE".';
//
//        $test = function (): void {
//            $this->getTesteeInstance(styleMode: OptionStyleMode::NONE);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }
}
