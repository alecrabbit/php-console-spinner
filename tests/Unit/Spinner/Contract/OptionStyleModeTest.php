<?php

declare(strict_types=1);

// 15.02.23
namespace AlecRabbit\Tests\Unit\Spinner\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class OptionStyleModeTest extends TestCase
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
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI8, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI4, OptionStyleMode::ANSI4, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI8, OptionStyleMode::ANSI24],
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI24, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI24, OptionStyleMode::ANSI24],
            [OptionStyleMode::ANSI4, OptionStyleMode::ANSI24, OptionStyleMode::ANSI4],
            [OptionStyleMode::NONE, OptionStyleMode::ANSI4, OptionStyleMode::NONE],
            [OptionStyleMode::NONE, OptionStyleMode::ANSI8, OptionStyleMode::NONE],
            [OptionStyleMode::NONE, OptionStyleMode::ANSI24, OptionStyleMode::NONE],
            [OptionStyleMode::NONE, OptionStyleMode::NONE, OptionStyleMode::ANSI8],
            [OptionStyleMode::NONE, OptionStyleMode::NONE, OptionStyleMode::ANSI4],
            [OptionStyleMode::NONE, OptionStyleMode::NONE, OptionStyleMode::ANSI24],
            [OptionStyleMode::NONE, OptionStyleMode::NONE, null],
        ];
    }

    public static function highestDataProvider(): iterable
    {
        // [$expected, $incoming]
        // #0..
        foreach (self::simplifiedHighestDataFeeder() as $item) {
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

    public static function simplifiedHighestDataFeeder(): iterable
    {
        // #0..
        yield from [
            // result, modeOne, modeTwo // first element - #0..
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI8, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI4, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI8, OptionStyleMode::ANSI24],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI24, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI24, OptionStyleMode::ANSI24],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI24, OptionStyleMode::ANSI4],
            [OptionStyleMode::ANSI4, OptionStyleMode::ANSI4, OptionStyleMode::NONE],
            [OptionStyleMode::ANSI8, OptionStyleMode::ANSI8, OptionStyleMode::NONE],
            [OptionStyleMode::ANSI24, OptionStyleMode::ANSI24, OptionStyleMode::NONE],
            [OptionStyleMode::ANSI8, OptionStyleMode::NONE, OptionStyleMode::ANSI8],
            [OptionStyleMode::ANSI4, OptionStyleMode::NONE, OptionStyleMode::ANSI4],
            [OptionStyleMode::ANSI24, OptionStyleMode::NONE, OptionStyleMode::ANSI24],
            [OptionStyleMode::NONE, OptionStyleMode::NONE, null],
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
            [true, OptionStyleMode::ANSI8,],
            [true, OptionStyleMode::ANSI4,],
            [true, OptionStyleMode::ANSI8,],
            [true, OptionStyleMode::ANSI24,],
            [true, OptionStyleMode::ANSI24,],
            [true, OptionStyleMode::ANSI24,],
            [true, OptionStyleMode::ANSI4,],
            [true, OptionStyleMode::ANSI8,],
            [true, OptionStyleMode::ANSI24,],
            [false, OptionStyleMode::NONE,],
            [false, OptionStyleMode::NONE,],
            [false, OptionStyleMode::NONE,],
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
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT]->value, $result->value);
        self::assertSame($expected[self::RESULT]->name, $result->name);
    }

    #[Test]
    #[DataProvider('highestDataProvider')]
    public function canDetermineHighest(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $result = $args[self::MODE_ONE]->highest($args[self::MODE_TWO]);

        if ($expectedException) {
            self::failTest($expectedException);
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
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }
}
