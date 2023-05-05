<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Ansi8Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi8ColorTest extends TestCase
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
                    self::INDEX => 256,
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
            ['#ff0000', 196, null],
            [196, null, '#ff0000'],
            ['#ff5f87', 204, null],
            [204, null, '#ff5f87'],
            ['#af87ff', 141, null],
            [141, null, '#af87ff'],
            ['#eeeeee', 255, null],
            [255, null, '#eeeeee'],
            ['#808080', 244, null],
            [244, null, '#808080'],
            ['#000000', 16, null],
            [16, null, '#000000'],
            ['#800000', 1, null],
            [1, null, '#800000'],
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
                ? Ansi8Color::getIndex($hex)
                : Ansi8Color::getHexColor($index);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}
