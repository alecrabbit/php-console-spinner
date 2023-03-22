<?php

declare(strict_types=1);
// 21.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Style\CustomStyle;
use AlecRabbit\Spinner\Core\OldStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class OldStyleFrameRendererTest extends TestCase
{
    public static function collectionData(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([196], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];
        #1
        yield [
            [
                self::COUNT => 2,
                self::LAST_INDEX => 1,
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                    FrameFactory::create("\e[38;5;197m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle([196, 197], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];
        #2
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle(['#ff0000',], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];
        #3
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN => new CustomStyle(['#ff0000',], colorMode: ColorMode::ANSI8),
                ],
            ],
        ];
        #4
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Array should contain 2 elements, 0 given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [[],],
                            colorMode: ColorMode::ANSI8
                        ),
                ],
            ],
        ];
        #5
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Array should contain keys "fg" and "bg", keys ["0", "1"] given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [[0, 1],],
                            colorMode: ColorMode::ANSI8
                        ),
                ],
            ],
        ];
        #6
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => 'Array should contain keys "fg" and "bg", keys ["fg", "bq"] given.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [['fg' => '', 'bq' => ''],],
                            colorMode: ColorMode::ANSI8
                        ),
                ],
            ],
        ];
        #7
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;196;48;5;231m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [['fg' => '#ff0000', 'bg' => '#ffffff'],],
                            colorMode: ColorMode::ANSI8
                        ),
                ],
            ],
        ];
        #8
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[38;5;231;48;5;196m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [['fg' => '#fff', 'bg' => '#f00'],],
                            colorMode: ColorMode::ANSI8
                        ),
                ],
            ],
        ];
        #9
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[38;2;255;255;255;48;2;255;0;0m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [['fg' => '#fff', 'bg' => '#f00'],],
                            colorMode: ColorMode::ANSI24
                        ),
                ],
            ],
        ];
        #10
        yield [
            [
                self::COUNT => 1,
                self::LAST_INDEX => 0,
                self::FRAMES => [
                    FrameFactory::create("\e[37;41m%s\e[0m", 0),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::PATTERN =>
                        new CustomStyle(
                            [['fg' => '#fff', 'bg' => '#f00'],],
                            colorMode: ColorMode::ANSI4
                        ),
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

        $collection = (new OldStyleFrameCollectionRenderer($args[self::PATTERN]))->render();

        if ($expectedException) {
            self::exceptionNotThrown($expectedException, dataSet: [$expected, $incoming]);
        }

        self::assertSame($expected[self::COUNT] ?? 1, $collection->count());
        self::assertEquals($expected[self::FRAMES] ?? null, dump($collection->getArrayCopy()));
        self::assertSame($expected[self::LAST_INDEX] ?? 0, $collection->lastIndex());
    }
}
