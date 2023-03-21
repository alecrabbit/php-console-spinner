<?php

declare(strict_types=1);
// 21.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class ColorModeTest extends TestCase
{
    public static function collectionData(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should not be empty string.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => '',
                ],
            ],
        ];
        #1
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI8 color mode value should be in range 0..255, 345 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => 345,
                ],
            ],
        ];
        #2
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be positive integer, -3 given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => -3,
                ],
            ],
        ];
        #3
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => LogicException::class,
                    self::MESSAGE => sprintf(
                        '%s::NONE: Unable to convert "1" to ansi code.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::NONE,
                    self::COLOR => 1,
                ],
            ],
        ];
        #4
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'For %s::ANSI4 color mode value should be in range 0..15, 22 given.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI4,
                    self::COLOR => 22,
                ],
            ],
        ];
        #5
        yield [
            [
                self::RESULT => '8;5;196',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => '#ff0000',
                ],
            ],
        ];
        #5
        yield [
            [
                self::RESULT => '8;5;196',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => '#ff0001',
                ],
            ],
        ];
        #6
        yield [
            [
                self::RESULT => '8;5;226',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => '#ffee12',
                ],
            ],
        ];
        #6
        yield [
            [
                self::RESULT => '8;2;255;238;18',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI24,
                    self::COLOR => '#ffee12',
                ],
            ],
        ];
        #7
        yield [
            [
                self::RESULT => '3',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI4,
                    self::COLOR => '#ffee12',
                ],
            ],
        ];
        #8
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => LogicException::class,
                    self::MESSAGE => sprintf(
                        '%s::NONE: Unable to convert "#ffee12" to ansi code.',
                        ColorMode::class,
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::NONE,
                    self::COLOR => '#ffee12',
                ],
            ],
        ];
        #9
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "ffee12" given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::NONE,
                    self::COLOR => 'ffee12',
                ],
            ],
        ];
        #10
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Value should be a valid hex color code("#rgb", "#rrggbb"), "#ffe12" given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::NONE,
                    self::COLOR => '#ffe12',
                ],
            ],
        ];
        #11
        yield [
            [
                self::RESULT => '7',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI4,
                    self::COLOR => '#fff',
                ],
            ],
        ];
        #12
        yield [
            [
                self::RESULT => '8;5;231',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI8,
                    self::COLOR => '#fff',
                ],
            ],
        ];
        #13
        yield [
            [
                self::RESULT => '8;2;255;255;255',
            ],
            [
                self::ARGUMENTS => [
                    self::MODE => ColorMode::ANSI24,
                    self::COLOR => '#fff',
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('collectionData')]
    public function canBeCreated(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

//        $collection = (new StyleFrameRenderer($args[self::PATTERN]))->render();
        $code = $args[self::MODE]->ansiCode($args[self::COLOR]);

        if ($expectedException) {
            self::exceptionNotThrown($expectedException);
        }

        self::assertEquals($expected[self::RESULT] ?? null, $code);
    }
}
