<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Contract;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
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
            [StylingMethodOption::ANSI8, StylingMethodOption::ANSI8, StylingMethodOption::ANSI8],
            [StylingMethodOption::ANSI4, StylingMethodOption::ANSI4, StylingMethodOption::ANSI8],
            [StylingMethodOption::ANSI8, StylingMethodOption::ANSI8, StylingMethodOption::ANSI24],
            [StylingMethodOption::ANSI8, StylingMethodOption::ANSI24, StylingMethodOption::ANSI8],
            [StylingMethodOption::ANSI24, StylingMethodOption::ANSI24, StylingMethodOption::ANSI24],
            [StylingMethodOption::ANSI4, StylingMethodOption::ANSI24, StylingMethodOption::ANSI4],
            [StylingMethodOption::NONE, StylingMethodOption::ANSI4, StylingMethodOption::NONE],
            [StylingMethodOption::NONE, StylingMethodOption::ANSI8, StylingMethodOption::NONE],
            [StylingMethodOption::NONE, StylingMethodOption::ANSI24, StylingMethodOption::NONE],
            [StylingMethodOption::NONE, StylingMethodOption::NONE, StylingMethodOption::ANSI8],
            [StylingMethodOption::NONE, StylingMethodOption::NONE, StylingMethodOption::ANSI4],
            [StylingMethodOption::NONE, StylingMethodOption::NONE, StylingMethodOption::ANSI24],
            [StylingMethodOption::NONE, StylingMethodOption::NONE, null],
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
}
