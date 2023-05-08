<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\RGBColor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBColorTest extends TestCase
{
    public static function colorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedColorDataFeeder() as $item) {
            yield [
                [
                    self::TO_STRING => $item[0], // result
                    self::RESULT => $item[1], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::RED => $item[2],
                        self::GREEN => $item[3],
                        self::BLUE => $item[4],
                        self::ALPHA => $item[5],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // toString, result, r, g, b, a // first element - #0..
            ['#000000', new RGBColor(0, 0, 0, 1.0), 0, 0, 0, 1.0],
            ['#0000ff', new RGBColor(0, 0, 0xff, 0.1), 0, 0, 0xff, 0.1],
            ['#0000ff', new RGBColor(0, 0, 255, 1.0), -1, -1, 300, 3.0],
            ['#00f1ff', new RGBColor(0, 241, 255, 1.0), -1, 241, 300, 3.0],
            ['#0000ff', new RGBColor(0, 0, 255, 0.0), -1, -1, 300, -2.0],
            ['#32aaff', new RGBColor(0x32, 0xaa, 0xff, 0.3), 0x32, 0xaa, 0xff, 0.3],
        ];
    }

    public static function invalidStringDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedInvalidStringDataFeeder() as $string) {
            yield [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgumentException::class,
                        self::MESSAGE => "Invalid color string: \"{$string}\".",
                    ],
                ],
                [
                    self::COLOR => $string,
                ],
            ];
        }
    }

    private static function simplifiedInvalidStringDataFeeder(): iterable
    {
        yield from [
            'rgb(145, 89, 34,)',
            'hsl(145, 89%, 34%)',
            'hsla(145, 89%, 34%, 0.5)',
            'ffaaa',
            'aaaaa',
            '00000',
            '#aabbccdd',
            '#aabbc',
            'nanana',
        ];
    }

    public static function hexColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedHexColorDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[1], // result
                    self::TO_STRING => $item[2],
                    self::TO_HEX => $item[3],
                    self::TO_RGB => $item[4],
                    self::TO_RGBA => $item[5],
                ],
                [
                    self::ARGUMENTS => [
                        self::HEX => $item[0],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedHexColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // hex, result, toString, toHex, toRgb, to Rgba // first element - #0..
            ['#000', new RGBColor(0, 0, 0), '#000000', '#000000', 'rgb(0, 0, 0)', 'rgba(0, 0, 0, 1)'],
            ['000', new RGBColor(0, 0, 0), '#000000', '#000000', 'rgb(0, 0, 0)', 'rgba(0, 0, 0, 1)'],
            ['#00f', new RGBColor(0, 0, 255), '#0000ff', '#0000ff', 'rgb(0, 0, 255)', 'rgba(0, 0, 255, 1)'],
            ['00f', new RGBColor(0, 0, 255), '#0000ff', '#0000ff', 'rgb(0, 0, 255)', 'rgba(0, 0, 255, 1)'],
            ['#00f1ff', new RGBColor(0, 241, 255), '#00f1ff', '#00f1ff', 'rgb(0, 241, 255)', 'rgba(0, 241, 255, 1)'],
            ['#0000ff', new RGBColor(0, 0, 255), '#0000ff', '#0000ff', 'rgb(0, 0, 255)', 'rgba(0, 0, 255, 1)'],
            [
                '#b4f598',
                new RGBColor(180, 245, 152),
                '#b4f598',
                '#b4f598',
                'rgb(180, 245, 152)',
                'rgba(180, 245, 152, 1)'
            ],
            ['#915922', new RGBColor(145, 89, 34), '#915922', '#915922', 'rgb(145, 89, 34)', 'rgba(145, 89, 34, 1)'],
            ['#00ff80', new RGBColor(0, 255, 128), '#00ff80', '#00ff80', 'rgb(0, 255, 128)', 'rgba(0, 255, 128, 1)'],
        ];
    }

    public static function stringColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedStringColorDataFeeder() as $item) {
            yield [
                [
                    self::TO_HEX => $item[1],
                    self::TO_RGB => $item[2],
                    self::TO_RGBA => $item[3],
                    self::COLOR => $item[0],
                ],
            ];
        }
    }

    public static function simplifiedStringColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // color, hex, rgb, rgba // first element - #0..
            [new RGBColor(0, 0, 0), '#000000', 'rgb(0, 0, 0)', 'rgba(0, 0, 0, 1)'],
            [new RGBColor(0, 0, 255), '#0000ff', 'rgb(0, 0, 255)', 'rgba(0, 0, 255, 1)'],
            [new RGBColor(0, 241, 255), '#00f1ff', 'rgb(0, 241, 255)', 'rgba(0, 241, 255, 1)'],
            [new RGBColor(0, 0, 255), '#0000ff', 'rgb(0, 0, 255)', 'rgba(0, 0, 255, 1)'],
            [new RGBColor(180, 245, 152), '#b4f598', 'rgb(180, 245, 152)', 'rgba(180, 245, 152, 1)'],
            [new RGBColor(180, 245, 152, 0.45), '#b4f598', 'rgb(180, 245, 152)', 'rgba(180, 245, 152, 0.45)'],
            [new RGBColor(145, 89, 34), '#915922', 'rgb(145, 89, 34)', 'rgba(145, 89, 34, 1)'],
            [new RGBColor(145, 89, 34, 0.11), '#915922', 'rgb(145, 89, 34)', 'rgba(145, 89, 34, 0.11)'],
            [new RGBColor(0, 255, 128), '#00ff80', 'rgb(0, 255, 128)', 'rgba(0, 255, 128, 1)'],
        ];
    }


    #[Test]
    #[DataProvider('colorDataProvider')]
    public function canBeCreated(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result =
            new RGBColor(
                $args[self::RED],
                $args[self::GREEN],
                $args[self::BLUE],
                $args[self::ALPHA],
            );

        if ($expectedException) {
            self::failTest($expectedException);
        }

        $expectedResult = $expected[self::RESULT];
        $toString = $expected[self::TO_STRING];

        self::assertEquals($toString, (string)$result);

        self::assertEquals($expectedResult, $result);
        self::assertSame($expectedResult->red, $result->red);
        self::assertSame($expectedResult->green, $result->green);
        self::assertSame($expectedResult->blue, $result->blue);
        self::assertSame($expectedResult->alpha, $result->alpha);
    }

    #[Test]
    #[DataProvider('hexColorDataProvider')]
    public function canBeCreatedFromHex(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = RGBColor::fromString($args[self::HEX]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        self::assertEquals($expected[self::TO_STRING], (string)$result);
        self::assertEquals($expected[self::TO_HEX], $result->toHexString());
        self::assertEquals($expected[self::TO_RGB], $result->toRgbString());
        self::assertEquals($expected[self::TO_RGBA], $result->toRgbaString());
    }

    #[Test]
    #[DataProvider('stringColorDataProvider')]
    public function canBeCreatedFromString(array $expected): void
    {
        /** @var RGBColor $color */
        $color = $expected[self::COLOR];

        $hex = $expected[self::TO_HEX];
        $rgb = $expected[self::TO_RGB];
        $rgba = $expected[self::TO_RGBA];

        self::assertSame($color->toHexString(), $hex);
        self::assertSame($color->toRgbString(), $rgb);
        self::assertSame($color->toRgbaString(), $rgba);

        self::assertEquals(RGBColor::fromString($hex)->toHexString(), $color->toHexString());
        self::assertEquals(RGBColor::fromString($rgb)->toRgbString(), $color->toRgbString());
        self::assertEquals(RGBColor::fromString($rgba)->toRgbaString(), $color->toRgbaString());
    }

    #[Test]
    #[DataProvider('invalidStringDataProvider')]
    public function throwsIfInvalidStringProvided(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $this->wrapExceptionTest(
            fn() => RGBColor::fromString($incoming[self::COLOR]),
            $expectedException,
        );
    }
}
