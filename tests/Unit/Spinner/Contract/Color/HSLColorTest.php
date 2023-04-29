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
            [new HSLColor(359, 0, 0, 1.0), -1, 0, 0, 1.0],
            [new HSLColor(359, 1, 0, 1.0), -1, 2, 0, 1.0],
            [new HSLColor(14, 0, 1, 0), 14, 0, 2, -1],
            [new HSLColor(114, 0.5, 0.5, 1), 114, 0.5, 0.5, 1],
            [new HSLColor(359, 0.5, 0.5, 1), -1, 0.5, 0.5, 1],
        ];
    }

    public static function stringColorDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedStringColorDataFeeder() as $item) {
            yield [
                [
                    self::TO_HSL => $item[1],
                    self::TO_HSLA => $item[2],
                ],
                [
                    self::COLOR => $item[0],
                ],
            ];
        }
    }

    public static function simplifiedStringColorDataFeeder(): iterable
    {
        // #0..
        yield from [
            // color, toHsl, toHsla, // first element - #0..
            [new HSLColor(0, 0, 0, 1), 'hsl(0, 0%, 0%)', 'hsla(0, 0%, 0%, 1)'],
            [new HSLColor(350, 0.2, 0, 0.5), 'hsl(350, 20%, 0%)', 'hsla(350, 20%, 0%, 0.5)',],
            [new HSLColor(32, 0.34, 1, 0.55), 'hsl(32, 34%, 100%)', 'hsla(32, 34%, 100%, 0.55)',],
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

        $color = $incoming[self::COLOR];

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::TO_HSL], $color->toHSL());
        self::assertSame($expected[self::TO_HSLA], $color->toHSLA());
    }
}
