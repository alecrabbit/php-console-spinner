<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Core\Color\HSLColor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLColorTest extends TestCase
{
    public static function colorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedColorDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::HUE => $item[1],
                        self::SATURATION => $item[2],
                        self::LIGHTNESS => $item[3],
                        self::ALPHA => $item[4],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, h, s, l, a // first element - #0..
            [new HSLColor(0, 0, 0, 1.0), 0, 0, 0, 1.0],
            [new HSLColor(0, 0, 0, 1.0), -1, 0, 0, 1.0],
            [new HSLColor(0, 1, 0, 1.0), -1, 2, 0, 1.0],
            [new HSLColor(14, 0, 1, 0), 14, 0, 2, -1],
        ];
    }

    public static function stringColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedStringColorDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0], // result
                    self::TO_HSL => $item[1],
                    self::TO_HSLA => $item[2],

                ],
                [
                    self::ARGUMENTS => [
                        self::HUE => $item[3],
                        self::SATURATION => $item[4],
                        self::LIGHTNESS => $item[5],
                        self::ALPHA => $item[6],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedStringColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, toHsl, toHsla, h, s, l, a // first element - #0..
            [new HSLColor(0, 0, 0, 1), 'hsl(0, 0%, 0%)', 'hsla(0, 0%, 0%, 1)', 0, 0, 0, 1],
            [
                new HSLColor(350, 0.2, 0, 0.5),
                'hsl(350, 20%, 0%)',
                'hsla(350, 20%, 0%, 0.5)',
                350,
                0.2,
                0,
                0.5
            ],
        ];
    }

    #[Test]
    #[DataProvider('colorDataProvider')]
    public function canBeCreatedFromValues(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result =
            new HSLColor(
                $args[self::HUE],
                $args[self::SATURATION],
                $args[self::LIGHTNESS],
                $args[self::ALPHA],
            );

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);

        self::assertSame($expected[self::RESULT]->hue, $result->hue);
        self::assertSame($expected[self::RESULT]->saturation, $result->saturation);
        self::assertSame($expected[self::RESULT]->lightness, $result->lightness);
        self::assertSame($expected[self::RESULT]->alpha, $result->alpha);
    }

    #[Test]
    #[DataProvider('stringColorDataProvider')]
    public function canHslaString(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result =
            new HSLColor(
                $args[self::HUE],
                $args[self::SATURATION],
                $args[self::LIGHTNESS],
                $args[self::ALPHA],
            );

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        
        self::assertSame($expected[self::RESULT]->hue, $result->hue);
        self::assertSame($expected[self::RESULT]->saturation, $result->saturation);
        self::assertSame($expected[self::RESULT]->lightness, $result->lightness);
        self::assertSame($expected[self::RESULT]->alpha, $result->alpha);

        self::assertSame($expected[self::TO_HSL], $result->toHSL());
        self::assertSame($expected[self::TO_HSLA], $result->toHSLA());
    }
}
