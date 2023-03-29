<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Core\Color\HSLColor;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
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


    #[Test]
    #[DataProvider('colorDataProvider')]
    public function canDetermineLowest(array $expected, array $incoming): void
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
            self::exceptionNotThrown($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        self::assertSame($expected[self::RESULT]->hue, $result->hue);
        self::assertSame($expected[self::RESULT]->saturation, $result->saturation);
        self::assertSame($expected[self::RESULT]->lightness, $result->lightness);
        self::assertSame($expected[self::RESULT]->alpha, $result->alpha);
    }
}


