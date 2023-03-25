<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Color;

use AlecRabbit\Spinner\Core\Color\Ansi8Color;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
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
            ['#ff0000', 196, null,],
            [196, null, '#ff0000',],
            ['#ff5f87', 204, null,],
            [204, null, '#ff5f87',],
            ['#af87ff', 141, null,],
            [141, null, '#af87ff',],
            ['#eeeeee', 255, null,],
            [255, null, '#eeeeee',],
            ['#808080', 244, null,],
            [244, null, '#808080',],
            ['#000000', 16, null,],
            [16, null, '#000000',], //"#808080" => 244
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

        $this->assertIncomingArguments($index, $hex);

        if (null !== $index && null === $hex) {
            $result = Ansi8Color::getHexColor($index);
        }

        if (null !== $hex && null === $index) {
            $result = Ansi8Color::getIndex($hex);
        }

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertIncomingArguments(mixed $index, mixed $hex): void
    {
        if (null === $index && null === $hex) {
            self::fail('Both index and hex arguments are null.');
        }
        if (null !== $index && null !== $hex) {
            self::fail('Both index and hex arguments are not null.');
        }
    }
}


