<?php

declare(strict_types=1);
// 21.03.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Color\Style;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Char\CustomPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Pattern\Style\CustomStylePattern;
use AlecRabbit\Spinner\Core\StyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class StyleFrameCollectionRendererTest extends TestCase
{
    public static function collectionDataProvider(): iterable
    {
        // [$expected, $incoming]
        #0
        yield [
            [
                self::FRAMES => [
                    FrameFactory::create('%s', 0),
                ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::NONE,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::NONE
                        ),
                ],
            ],
        ];
        #1
        yield [
            [
                self::FRAMES => [
                    StaticFrameFactory::create('%s', 0),
                ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::NONE,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::ANSI4
                        ),
                ],
            ],
        ];
        #2
        yield [
            [
                self::FRAMES => [
                    StaticFrameFactory::create('%s', 0),
                ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::NONE,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::ANSI8
                        ),
                ],
            ],
        ];
        #3
        yield [
            [
                self::FRAMES => [
                    StaticFrameFactory::create('%s', 0),
                ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::NONE,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::ANSI24
                        ),
                ],
            ],
        ];
        #4
        yield [
            [
                // self::FRAMES => [
                //     FrameFactory::create("\e[38;2;255;0;0m%s\e[0m", 0),
                // ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::ANSI24,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::ANSI24
                        ),
                ],
            ],
        ];
        #5
        yield [
            [
                // self::FRAMES => [
                //     FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                // ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::ANSI8,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [new Style('#ff0000')],
                            styleMode: OptionStyleMode::ANSI8
                        ),
                ],
            ],
        ];
        #6
        yield [
            [
                self::COUNT => 2,
                self::LAST_INDEX => 1,
                // self::FRAMES => [
                //     FrameFactory::create("\e[38;5;196;48;5;16m%s\e[0m", 0),
                //     FrameFactory::create("\e[38;5;197m%s\e[0m", 0),
                // ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::ANSI8,
                    self::PATTERN =>
                        new CustomStylePattern(
                            [
                                new Style('#ff0000', '#000000'),
                                new Style('#ff005f')
                            ],
                            styleMode: OptionStyleMode::ANSI8
                        ),
                ],
            ],
        ];
        #7
        $pattern = new CustomPattern(['1'],);
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgumentException::class,
                    self::MESSAGE => sprintf(
                        'Pattern should be instance of "%s", "%s" given.',
                        IStylePattern::class,
                        get_debug_type($pattern)
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::ANSI8,
                    self::PATTERN => $pattern,
                ],
            ],
        ];
        #8
        yield [
            [
                // self::FRAMES => [
                //     FrameFactory::create("\e[38;5;196m%s\e[0m", 0),
                // ],
                self::COUNT => 1,
            ],
            [
                self::ARGUMENTS => [
                    self::COLOR_MODE => OptionStyleMode::ANSI8,
                    self::PATTERN =>
                        new CustomStylePattern(
                            ['#ff0000'],
                            styleMode: OptionStyleMode::ANSI8
                        ),
                ],
            ],
        ];
//        #5
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Array should contain keys "fg" and "bg", keys ["0", "1"] given.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI4,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [[0, 1],],
//                        ),
//                ],
//            ],
//        ];
//        #6
//        yield [
//            [
//                self::EXCEPTION => [
//                    self::CLASS_ => InvalidArgumentException::class,
//                    self::MESSAGE => 'Array should contain keys "fg" and "bg", keys ["fg", "bq"] given.',
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI4,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '', 'bq' => ''],],
//                        ),
//                ],
//            ],
//        ];
//        #7
//        yield [
//            [
//                self::COUNT => 1,
//                self::LAST_INDEX => 0,
//                self::FRAMES => [
//                    FrameFactory::create("\e[38;5;196;48;5;231m%s\e[0m", 0),
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI24,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '#ff0000', 'bg' => '#ffffff'],],
//                            colorMode: ColorMode::ANSI8
//                        ),
//                ],
//            ],
//        ];
//        #8
//        yield [
//            [
//                self::COUNT => 1,
//                self::LAST_INDEX => 0,
//                self::FRAMES => [
//                    FrameFactory::create("\e[38;5;231;48;5;196m%s\e[0m", 0),
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI24,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '#fff', 'bg' => '#f00'],],
//                            colorMode: ColorMode::ANSI8
//                        ),
//                ],
//            ],
//        ];
//        #9
//        yield [
//            [
//                self::COUNT => 1,
//                self::LAST_INDEX => 0,
//                self::FRAMES => [
//                    FrameFactory::create("\e[38;2;255;255;255;48;2;255;0;0m%s\e[0m", 0),
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI24,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '#fff', 'bg' => '#f00'],],
//                            colorMode: ColorMode::ANSI24
//                        ),
//                ],
//            ],
//        ];
//        #10
//        yield [
//            [
//                self::COUNT => 1,
//                self::LAST_INDEX => 0,
//                self::FRAMES => [
//                    FrameFactory::create("\e[37;41m%s\e[0m", 0),
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI24,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '#fff', 'bg' => '#f00'],],
//                            colorMode: ColorMode::ANSI4
//                        ),
//                ],
//            ],
//        ];
//        #11
//        yield [
//            [
//                self::COUNT => 1,
//                self::LAST_INDEX => 0,
//                self::FRAMES => [
//                    FrameFactory::create("\e[37;41m%s\e[0m", 0),
//                ],
//            ],
//            [
//                self::ARGUMENTS => [
//                    self::COLOR_MODE => ColorMode::ANSI24,
//                    self::PATTERN =>
//                        new CustomStylePattern(
//                            [['fg' => '#fff', 'bg' => '#f00'],],
//                            colorMode: ColorMode::ANSI4
//                        ),
//                ],
//            ],
//        ];
    }

    #[Test]
    #[DataProvider('collectionDataProvider')]
    public function canBeCreated(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $renderer =
            new StyleFrameCollectionRenderer(
                new StyleFrameRenderer(
                    new AnsiStyleConverter($args[self::COLOR_MODE])
                ),
            );

        $rendererWithPattern = $renderer->pattern($args[self::PATTERN]);

        $collection = $rendererWithPattern->render();

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::COUNT] ?? 1, $collection->count());
        $frames = $expected[self::FRAMES] ?? null;
        if ($frames) {
            self::assertEquals($frames, $collection->getArrayCopy());
        }
        self::assertSame($expected[self::LAST_INDEX] ?? 0, $collection->lastIndex());
    }
}