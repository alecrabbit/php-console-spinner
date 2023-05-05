<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Ansi4Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi4ColorTest extends TestCase
{
    public static function DataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    // do not expect specific message
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::INDEX => -1,
                ],
            ],
        ];
        // #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    // do not expect specific message
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::INDEX => 32,
                ],
            ],
        ];
        // #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    // do not expect specific message
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::HEX => '256',
                ],
            ],
        ];
        // #3..
        foreach (self::simplifiedDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::INDEX => $item[1], // index
                        self::HEX => $item[2], // hex
                    ],
                ],
            ];
        }
    }

    public static function simplifiedDataFeeder(): iterable
    {
        // #3..
        yield from [
            // result, index, hex // first element - #3
            ['#000000', 0, null],
            ['#800000', 1, null],
            ['#008000', 2, null],
            ['#808000', 3, null],
            ['#000080', 4, null],
            ['#800080', 5, null],
            ['#008080', 6, null],
            ['#c0c0c0', 7, null],
            ['#808080', 8, null],
            ['#ff0000', 9, null],
            ['#00ff00', 10, null],
            ['#ffff00', 11, null],
            ['#0000ff', 12, null],
            ['#ff00ff', 13, null],
            ['#00ffff', 14, null],
            ['#ffffff', 15, null],
            [0, null, '#000000'],
            [1, null, '#800000'],
            [2, null, '#008000'],
            [3, null, '#808000'],
            [4, null, '#000080'],
            [5, null, '#800080'],
            [6, null, '#008080'],
            [7, null, '#c0c0c0'],
            [8, null, '#808080'],
            [9, null, '#ff0000'],
            [10, null, '#00ff00'],
            [11, null, '#ffff00'],
            [12, null, '#0000ff'],
            [13, null, '#ff00ff'],
            [14, null, '#00ffff'],
            [15, null, '#ffffff'],

        ];
    }

    #[Test]
    #[DataProvider('DataProvider')]
    public function canGiveColorIndexOrHexString(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $index = $args[self::INDEX] ?? null;
        $hex = $args[self::HEX] ?? null;

        if ($index === null && $hex === null) {
            self::fail('Both index and hex arguments are null.');
        }

        if ($index !== null && $hex !== null) {
            self::fail('Both index and hex arguments are not null.');
        }

        $result =
            $index === null
                ? Ansi4Color::getIndex($hex)
                : Ansi4Color::getHexColor($index);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}
