<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\IIntNormalizer;
use AlecRabbit\Spinner\Core\Color\Ansi8Color;
use AlecRabbit\Spinner\Core\IntNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi8ColorTest extends TestCase
{
    public static function DataProvider(): iterable
    {
        // [$expected, $incoming]
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
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be greater than 0.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::INTERVAL => 100,
//                    self::DIVISOR => 0,
//                ],
//            ],
//        ];
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Divisor should be less than 1000000.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::INTERVAL => 100,
//                    self::DIVISOR => 1200000,
//                ],
//            ],
//        ];
    }

    public static function simplifiedDataFeeder(): iterable
    {
        yield from [
            // result, index, hex
            [196, null, '#ff0000',],
            ['#ff0000', 196, null,],
        ];
    }

    #[Test]
    #[DataProvider('DataProvider')]
    public function canGiveColorIndexOrHexString(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = null; // failsafe

        $index = $args[self::INDEX] ?? null;
        $hex = $args[self::HEX] ?? null;

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
}


