<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
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
            // result, r, g, b, a // first element - #0..
            ['#000000', new RGBColor(0, 0, 0, 1.0), 0, 0, 0, 1.0],
            ['#0000ff', new RGBColor(0, 0, 255, 1.0), -1, -1, 300, 3.0],
            ['#00f1ff', new RGBColor(0, 241, 255, 1.0), -1, 241, 300, 3.0],
            ['#0000ff', new RGBColor(0, 0, 255, 0.0), -1, -1, 300, -2.0],
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
                    self::HEX => $item[2], // result to string
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
            // result, r, g, b, a // first element - #0..
            ['#000', new RGBColor(0, 0, 0, 1.0),'#000000',],
            ['#00f', new RGBColor(0, 0, 255, 1.0),'#0000ff',],
            ['#00f1ff', new RGBColor(0, 241, 255, 1.0),'#00f1ff',],
            ['#0000ff', new RGBColor(0, 0, 255, 1.0),'#0000ff',],
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
            self::exceptionNotThrown($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        self::assertEquals($expected[self::TO_STRING], (string)$result);
        self::assertSame($expected[self::RESULT]->red, $result->red);
        self::assertSame($expected[self::RESULT]->green, $result->green);
        self::assertSame($expected[self::RESULT]->blue, $result->blue);
        self::assertSame($expected[self::RESULT]->alpha, $result->alpha);
    }

    #[Test]
    #[DataProvider('hexColorDataProvider')]
    public function canBeCreatedFromHex(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = RGBColor::fromHex($args[self::HEX]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        self::assertEquals($expected[self::HEX], (string)$result);
    }
}


