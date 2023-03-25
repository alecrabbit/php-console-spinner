<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Contract;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class StyleModeTest extends TestCase
{
    public static function lowestDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedLowestDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::MODE_ONE => $item[1],
                        self::MODE_TWO => $item[2],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedLowestDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, modeOne, modeTwo // first element - #0..
            [StyleMode::ANSI8, StyleMode::ANSI8, StyleMode::ANSI8],
            [StyleMode::ANSI4, StyleMode::ANSI4, StyleMode::ANSI8],
            [StyleMode::ANSI8, StyleMode::ANSI8, StyleMode::ANSI24],
            [StyleMode::ANSI8, StyleMode::ANSI24, StyleMode::ANSI8],
            [StyleMode::ANSI24, StyleMode::ANSI24, StyleMode::ANSI24],
            [StyleMode::ANSI4, StyleMode::ANSI24, StyleMode::ANSI4],
            [StyleMode::NONE, StyleMode::ANSI4, StyleMode::NONE],
            [StyleMode::NONE, StyleMode::ANSI8, StyleMode::NONE],
            [StyleMode::NONE, StyleMode::ANSI24, StyleMode::NONE],
            [StyleMode::NONE, StyleMode::NONE, StyleMode::ANSI8],
            [StyleMode::NONE, StyleMode::NONE, StyleMode::ANSI4],
            [StyleMode::NONE, StyleMode::NONE, StyleMode::ANSI24],
        ];
    }

    public static function isStylingEnabledDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedIsStylingEnabledDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0], // result
                ],
                [
                    self::ARGUMENTS => [
                        self::MODE => $item[1],
                    ],
                ],
            ];
        }
    }

    public static function simplifiedIsStylingEnabledDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, mode // first element - #0..
            [true, StyleMode::ANSI8,],
            [true, StyleMode::ANSI4,],
            [true, StyleMode::ANSI8,],
            [true, StyleMode::ANSI24,],
            [true, StyleMode::ANSI24,],
            [true, StyleMode::ANSI24,],
            [true, StyleMode::ANSI4,],
            [true, StyleMode::ANSI8,],
            [true, StyleMode::ANSI24,],
            [false, StyleMode::NONE,],
            [false, StyleMode::NONE,],
            [false, StyleMode::NONE,],
        ];
    }

    #[Test]
    #[DataProvider('lowestDataProvider')]
    public function canDetermineLowest(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = $args[self::MODE_ONE]->lowest($args[self::MODE_TWO]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertSame($expected[self::RESULT]->value, $result->value);
        self::assertSame($expected[self::RESULT]->name, $result->name);
    }

    #[Test]
    #[DataProvider('isStylingEnabledDataProvider')]
    public function canDetermineIsStylingEnabled(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = $args[self::MODE]->isStylingEnabled();

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}


