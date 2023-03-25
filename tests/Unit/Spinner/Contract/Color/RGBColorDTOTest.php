<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Contract\Color;

use AlecRabbit\Spinner\Contract\Color\RGBColorDTO;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBColorDTOTest extends TestCase
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
                        self::RED => $item[1],
                        self::GREEN => $item[2],
                        self::BLUE => $item[3],
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
            // result, r, g, b, a // first element - #0..
            [new RGBColorDTO(0, 0, 0, 1.0), 0, 0, 0, 1.0],
            [new RGBColorDTO(0, 0, 255, 1.0), -1, -1, 300, 3.0],
            [new RGBColorDTO(0, 241, 255, 1.0), -1, 241, 300, 3.0],
            [new RGBColorDTO(0, 0, 255, 0.0), -1, -1, 300, -2.0],
        ];
    }


    #[Test]
    #[DataProvider('colorDataProvider')]
    public function canDetermineLowest(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result =
            new RGBColorDTO(
                $args[self::RED],
                $args[self::GREEN],
                $args[self::BLUE],
                $args[self::ALPHA],
            );

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
        self::assertSame($expected[self::RESULT]->red, $result->red);
        self::assertSame($expected[self::RESULT]->green, $result->green);
        self::assertSame($expected[self::RESULT]->blue, $result->blue);
        self::assertSame($expected[self::RESULT]->alpha, $result->alpha);
    }
}


